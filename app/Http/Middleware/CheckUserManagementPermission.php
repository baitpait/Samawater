<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserManagementPermission
{
    /**
     * Handle an incoming request.
     * 
     * يتحقق من أن المستخدم الحالي هو Super Admin
     * فقط Super Admin يمكنه إدارة المستخدمين
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = backpack_user();

        // التحقق من أن المستخدم مسجل دخول
        if (!$user) {
            abort(403, 'يجب تسجيل الدخول أولاً');
        }

        // التحقق من أن المستخدم هو Super Admin
        if (!$user->canManageUsers()) {
            abort(403, 'ليس لديك صلاحية لإدارة المستخدمين. فقط المسؤول الرئيسي يمكنه إدارة المستخدمين.');
        }

        return $next($request);
    }
}
