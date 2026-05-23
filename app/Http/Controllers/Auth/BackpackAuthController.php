<?php

namespace App\Http\Controllers\Auth;

use Backpack\CRUD\app\Http\Controllers\Auth\LoginController as BackpackLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Distributor;

/**
 * Business Purpose: تخصيص نظام تسجيل الدخول في Backpack لاستخدام رقم الهاتف بدلاً من Email.
 * 
 * هذا Controller يسمح للموزعين بتسجيل الدخول برقم الهاتف مباشرة،
 * بينما يسمح للمسؤولين بتسجيل الدخول بالـ Email.
 */
class BackpackAuthController extends BackpackLoginController
{
    /**
     * Business Purpose: التحقق من بيانات تسجيل الدخول.
     * 
     * يتحقق من:
     * - إذا كان الإدخال رقم هاتف (للموزعين) → البحث في distributors
     * - إذا كان الإدخال email (للمسؤولين) → البحث في users بالطريقة العادية
     */
    protected function credentials(Request $request)
    {
        $login = $request->get($this->username());
        
        // التحقق من إذا كان الإدخال رقم هاتف (يبدأ بـ 0 أو +)
        if (config('backpack.base.enable_phone_login', true) && preg_match('/^(\+?[0-9]{10,15})$/', $login)) {
            // البحث عن مستخدم برقم الهاتف
            $user = User::findByPhone($login);
            
            if ($user) {
                // استخدام email المستخدم للتحقق من كلمة المرور
                return [
                    'email' => $user->email,
                    'password' => $request->get('password'),
                ];
            }
        }
        
        // للمسؤولين: استخدام الطريقة العادية (email)
        return [
            $this->username() => $login,
            'password' => $request->get('password'),
        ];
    }

    /**
     * Business Purpose: تحديد اسم الحقل المستخدم في تسجيل الدخول.
     * 
     * للموزعين: يعرض "رقم الهاتف"
     * للمسؤولين: يعرض "البريد الإلكتروني"
     */
    public function username()
    {
        return 'email'; // Backpack يستخدم email افتراضياً
    }

    /**
     * Business Purpose: عرض صفحة تسجيل الدخول.
     * 
     * نستخدم نفس الـ view الافتراضي لكن مع تعديلات في الـ label.
     */
    public function showLoginForm()
    {
        // استخدام الـ parent method أولاً
        $response = parent::showLoginForm();
        
        // إضافة hint للموزعين إذا كان الـ response هو view
        if ($response instanceof \Illuminate\View\View) {
            $response->with('hint', 'للموزعين: استخدم رقم الهاتف. للمسؤولين: استخدم البريد الإلكتروني.');
        }
        
        return $response;
    }

    /**
     * Business Purpose: التحقق من صحة بيانات تسجيل الدخول قبل المحاولة.
     */
    protected function validateLogin(Request $request)
    {
        $login = $request->get($this->username());
        
        // إذا كان رقم هاتف، لا نحتاج validation خاص
        if (config('backpack.base.enable_phone_login', true) && preg_match('/^(\+?[0-9]{10,15})$/', $login)) {
            $request->validate([
                $this->username() => 'required|string',
                'password' => 'required|string',
            ]);
        } else {
            // للمسؤولين: validation عادي
            $request->validate([
                $this->username() => 'required|email',
                'password' => 'required|string',
            ]);
        }
    }

    /**
     * Business Purpose: توجيه المستخدم بعد تسجيل الدخول إلى لوحة التحكم.
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect(backpack_url('dashboard'));
    }

    /**
     * Business Purpose: تتبع أسباب فشل auth.failed وقت التشغيل (جلسة تصحيح — لا تسجل PII).
     */
    protected function attemptLogin(Request $request)
    {
        // #region agent log
        $loginRaw = $request->get($this->username());
        $loginStr = \is_string($loginRaw) ? $loginRaw : '';
        $phoneEnabled = config('backpack.base.enable_phone_login', true);
        $looksPhone = $phoneEnabled && (bool) preg_match('/^(\\+?[0-9]{10,15})$/', $loginStr);
        $looksEmailShape = filter_var($loginStr, FILTER_VALIDATE_EMAIL) !== false;

        $guard = $this->guard();
        $guardName = \is_object($guard) && method_exists($guard, 'getName')
            ? (string) $guard->getName()
            : get_debug_type($guard);
        $configBackpackGuard = config('backpack.base.guard');

        $resolvedForProbe = '';
        $phoneBridgeResolved = false;
        $uPhone = null;
        if ($looksPhone && $looksEmailShape === false) {
            $uPhone = User::findByPhone($loginStr);
            $phoneBridgeResolved = $uPhone !== null;
            $resolvedForProbe = $uPhone !== null ? 'phone_to_user_email' : 'phone_no_match';
        } elseif ($looksEmailShape) {
            $resolvedForProbe = 'email_direct';
        } else {
            $resolvedForProbe = 'ambiguous_or_empty';
        }

        $probeEmail = '';
        if ($uPhone !== null) {
            $probeEmail = (string) $uPhone->email;
        } elseif ($looksEmailShape) {
            $probeEmail = $loginStr;
        }

        $userRowExists = false;
        $bcryptLike = false;
        $hashAlgoHint = '';
        if ($probeEmail !== '') {
            $hash = DB::table('users')->where('email', $probeEmail)->value('password');
            $userRowExists = $hash !== null;
            if (\is_string($hash) && $hash !== '') {
                $bcryptLike = str_starts_with($hash, '$2y$') || str_starts_with($hash, '$2a$');
                $hashAlgoHint = str_starts_with($hash, '$2y$') ? 'bcrypt' : (str_starts_with($hash, '$2a$') ? 'bcrypt_legacy' : 'non_bcrypt');
            }
        }

        $pwLen = \is_string($request->get('password')) ? strlen((string) $request->get('password')) : 0;

        $this->agentLogNdjson([
            'hypothesisId' => 'H3',
            'message' => 'attemptLogin_guard_probe',
            'data' => [
                'guard_name' => $guardName,
                'config_backpack_guard' => $configBackpackGuard,
                'defaults_web_guard' => config('auth.defaults.guard'),
            ],
        ]);
        $this->agentLogNdjson([
            'hypothesisId' => 'H4',
            'message' => 'attemptLogin_input_shape',
            'data' => [
                'login_field_len' => strlen($loginStr),
                'looks_phone_pattern' => $looksPhone,
                'looks_email_shape' => $looksEmailShape,
                'resolved_for_probe' => $resolvedForProbe,
                'phone_bridge_resolved' => $phoneBridgeResolved,
            ],
        ]);
        $this->agentLogNdjson([
            'hypothesisId' => 'H2',
            'message' => 'attemptLogin_user_row_before_attempt',
            'data' => [
                'user_row_exists' => $userRowExists,
                'probe_had_email' => $probeEmail !== '',
                'password_len' => $pwLen,
            ],
        ]);
        $this->agentLogNdjson([
            'hypothesisId' => 'H5',
            'message' => 'attemptLogin_stored_hash_shape',
            'data' => [
                'stored_password_bcyrpt_like' => $bcryptLike,
                'hash_algo_hint' => $hashAlgoHint,
            ],
        ]);
        // #endregion

        $ok = parent::attemptLogin($request);

        // #region agent log
        $this->agentLogNdjson([
            'hypothesisId' => 'H1',
            'message' => 'attemptLogin_result',
            'data' => [
                'attempt_success' => (bool) $ok,
            ],
        ]);
        // #endregion

        return $ok;
    }

    /**
     * Business Purpose: تأكيد وصول Laravel إلى رسالة auth.failed وقت التشغيل.
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        // #region agent log
        $this->agentLogNdjson([
            'hypothesisId' => 'FAIL',
            'message' => 'send_failed_login_response',
            'data' => [
                'hint' => 'auth.failed_path',
            ],
        ]);
        // #endregion

        return parent::sendFailedLoginResponse($request);
    }

    // #region agent log
    /**
     * @param array{hypothesisId: string, message: string, data: array<string, mixed>} $row
     */
    private function agentLogNdjson(array $row): void
    {
        $line = json_encode(
            array_merge([
                'sessionId' => '4f6079',
                'timestamp' => (int) round(microtime(true) * 1000),
                'location' => 'BackpackAuthController.php',
                'runId' => 'pre-fix',
            ], $row),
            JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
        );
        @file_put_contents(base_path('.cursor/debug-4f6079.log'), ($line ?: '{}') . "\n", FILE_APPEND | LOCK_EX);
    }
    // #endregion
}
