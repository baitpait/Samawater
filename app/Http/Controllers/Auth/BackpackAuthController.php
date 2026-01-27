<?php

namespace App\Http\Controllers\Auth;

use Backpack\CRUD\app\Http\Controllers\Auth\LoginController as BackpackLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
}
