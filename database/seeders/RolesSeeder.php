<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء أنواع المستخدمين
        $roles = [
            [
                'name' => Role::NAME_SUPER_ADMIN,
                'display_name' => 'مسؤول رئيسي',
                'description' => 'المسؤول الرئيسي - يمكنه إدارة المستخدمين وجميع الصلاحيات',
                'is_super_admin' => true,
            ],
            [
                'name' => Role::NAME_ADMIN,
                'display_name' => 'مسؤول',
                'description' => 'مسؤول - له كل الصلاحيات إلا إدارة المستخدمين',
                'is_super_admin' => false,
            ],
            [
                'name' => Role::NAME_DISTRIBUTOR,
                'display_name' => 'موزع',
                'description' => 'موزع - صلاحيات محددة لعرض العملاء والتسليمات فقط',
                'is_super_admin' => false,
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                $role
            );
        }

        $this->command->info('تم إنشاء أنواع المستخدمين بنجاح!');
    }
}
