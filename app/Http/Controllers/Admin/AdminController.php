<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    /**
     * يعرض لوحة التحكم المناسبة حسب نوع المستخدم.
     * 
     * Business Purpose: توجيه المستخدم إلى لوحة التحكم الصحيحة بناءً على صلاحياته.
     * - الموزعون: لوحة تحكم مبسطة
     * - المسؤولون (Admin/Super Admin): لوحة تحكم كاملة
     */
    public function dashboard()
    {
        $user = backpack_user();
        
        if (!$user) {
            return redirect(backpack_url('login'));
        }
        
        // إذا كان المستخدم موزعاً فقط، عرض dashboard مبسط
        if ($user->isDistributor() && !$user->isAdminOrSuperAdmin()) {
            return view('admin.dashboard_distributor', [
                'title' => 'لوحة تحكم الموزع',
                'user' => $user,
            ]);
        }
        
        // للمسؤولين (Admin/Super Admin)، عرض dashboard كامل
        return view('admin.dashboard_admin', [
            'title' => 'لوحة تحكم الإدارة',
            'user' => $user,
        ]);
    }
}