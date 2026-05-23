<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Business Purpose: إصلاح حساب المدير التجريبي دون حذف بيانات تشغيلية (تسليمات، عملاء).
 * يطبق كلمة المرور كنص عادي فيُهاشها cast الـ hashed على نموذج User بطريقة Laravel القياسية.
 *
 * لحساب غير الافتراضي (مثل sama@ بعد استيراد SQL) استخدم أوامر الواجهة:
 * `php artisan sama:repair-admin-login user@example.com`
 */
class AdminLoginRepairSeeder extends Seeder
{
    private const DEFAULT_ADMIN_EMAIL = 'admin@sama.test';

    private const DEFAULT_ADMIN_PASSWORD = 'Admin@12345';

    public function run(): void
    {
        $roleId = Role::query()->where('name', Role::NAME_SUPER_ADMIN)->value('id');

        User::updateOrCreate(
            ['email' => self::DEFAULT_ADMIN_EMAIL],
            [
                'name' => 'مدير النظام',
                'password' => self::DEFAULT_ADMIN_PASSWORD,
                'role_id' => $roleId,
            ]
        );
    }
}
