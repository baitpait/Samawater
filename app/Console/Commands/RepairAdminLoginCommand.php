<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password as PasswordRule;

/**
 * Business Purpose: استعادة دخول مسؤول بعد استيراد SQL أو نسخ قاعدة قديمة بحيث تتغيّر كلمات المرور المخزّنة.
 * يُنفَّذ من SSH فقط ولا يُعرض كلمات المرور في السجلات.
 */
class RepairAdminLoginCommand extends Command
{
    protected $signature = 'sama:repair-admin-login
                            {email : البريد الإلكتروني للحساب}
                            {--force : تنفيذ دون سؤال تأكيد}';

    protected $description = 'تعيين كلمة مرور جديدة لمسؤول وربطه بدور super_admin (بعد استيراد نسخة احتياطية SQL)';

    public function handle(): int
    {
        $email = (string) $this->argument('email');
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('البريد غير صالح.');

            return self::FAILURE;
        }

        $roleId = Role::query()->where('name', Role::NAME_SUPER_ADMIN)->value('id');
        if ($roleId === null) {
            $this->error('دور super_admin غير موجود. شغّل أولاً: php artisan db:seed --class=RolesSeeder');

            return self::FAILURE;
        }

        if (! $this->option('force') && ! $this->confirm("سيتم تحديث كلمة المرور وربط الحساب بدور super_admin لـ: {$email}. هل تريد المتابعة؟", true)) {
            return self::SUCCESS;
        }

        $password = $this->secret('كلمة المرور الجديدة');
        if ($password === '' || $password === null) {
            $this->error('تم إلغاء العملية.');

            return self::FAILURE;
        }

        $confirm = $this->secret('تأكيد كلمة المرور');
        if ($password !== $confirm) {
            $this->error('كلمتا المرور غير متطابقتين.');

            return self::FAILURE;
        }

        $validator = Validator::make(
            ['password' => $password],
            ['password' => ['required', PasswordRule::min(8)]]
        );
        if ($validator->fails()) {
            $this->error($validator->errors()->first('password'));

            return self::FAILURE;
        }

        $user = User::query()->where('email', $email)->first();
        if ($user === null) {
            $user = new User();
            $user->email = $email;
            $user->name = 'مدير النظام';
        }

        $user->password = $password;
        $user->role_id = (int) $roleId;
        $user->distributor_id = null;
        $user->save();

        $this->info('تم تحديث الحساب. يمكنك تسجيل الدخول الآن.');

        return self::SUCCESS;
    }
}
