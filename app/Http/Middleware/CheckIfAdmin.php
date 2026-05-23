<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CheckIfAdmin
{
    private const DISTRIBUTOR_ALLOWED_ROUTE_NAMES = [
        'backpack.account.info',
        'backpack.account.info.update',
        'backpack.account.password',
        'backpack.account.password.update',
        'backpack.dashboard',
        'backpack.logout',
        'client.index',
        'client.search',
        'client.show',
        'reports.filters',
        'reports.filters.export.excel',
        'reports.filters.export.pdf',
        'reports.filters.toggle_delivery_on_demand',
        'reports.client-balance',
        'client.report',
        'client.report.pdf',
        'client.showDetailsRow',
        'delivery.list',
        'reports.clients_delivery_overview',
        'api.search.clients',
        // إضافة صفحات CRUD الأساسية للموزعين (إذا لزم الأمر)
        // 'city.index',
        // 'city.search',
        // 'subscription-type.index',
        // 'subscription-status.index',
        // 'client-type.index',
        // 'client-status.index',
    ];

    private const DISTRIBUTOR_ALLOWED_ROUTE_PREFIXES = [
        'delivery.',
        // يمكن إضافة prefixes أخرى هنا إذا أردت السماح للموزعين بالوصول لصفحات معينة
        // 'city.',
        // 'subscription-type.',
        // 'subscription-status.',
        // 'client-type.',
        // 'client-status.',
    ];

    private const DISTRIBUTOR_ALLOWED_PATH_PREFIXES = [
        'admin/edit-account-info',
        'admin/account',
        'admin/logout',
    ];
    /**
     * Checked that the logged in user is an administrator.
     *
     * --------------
     * VERY IMPORTANT
     * --------------
     * If you have both regular users and admins inside the same table, change
     * the contents of this method to check that the logged in user
     * is an admin, and not a regular user.
     *
     * Additionally, in Laravel 7+, you should change app/Providers/RouteServiceProvءider::HOME
     * which defines the route where a logged in user (but not admin) gets redirected
     * when trying to access an admin route. By default it's '/home' but Backpack
     * does not have a '/home' route, use something you've built for your users
     * (again - users, not admins).
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @return bool
     */
    private function checkIfUserIsAdmin($user): bool
    {
        if ($user === null) {
            return false;
        }

        return $user->hasAnyRole([
            Role::NAME_SUPER_ADMIN,
            Role::NAME_ADMIN,
            Role::NAME_DISTRIBUTOR,
        ]);
    }

    /**
     * Answer to unauthorized access request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    private function respondToUnauthorizedRequest(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response(trans('backpack::base.unauthorized'), 401);
        } else {
            return redirect()->guest(backpack_url('login'));
        }
    }

    /**
     * يرفض الوصول الصريح للمستخدم المسجل بدون صلاحية.
     *
     * @return \Illuminate\Http\Response
     */
    private function respondToForbiddenRequest(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response(trans('backpack::base.unauthorized'), 403);
        }

        abort(403, trans('backpack::base.unauthorized'));
    }

    /**
     * يحدد إن كان الموزع مسموحاً له بالوصول إلى المسار الحالي.
     */
    private function isDistributorAllowedRequest(Request $request): bool
    {
        $routeName = Route::currentRouteName();
        if (is_string($routeName)) {
            if (in_array($routeName, self::DISTRIBUTOR_ALLOWED_ROUTE_NAMES, true)) {
                return true;
            }

            foreach (self::DISTRIBUTOR_ALLOWED_ROUTE_PREFIXES as $prefix) {
                if (str_starts_with($routeName, $prefix)) {
                    return true;
                }
            }
        }

        $path = trim($request->path(), '/');
        foreach (self::DISTRIBUTOR_ALLOWED_PATH_PREFIXES as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return true;
            }
        }

        return false;
    }

    /**
     * يطبق سياسة الدخول للوحة التحكم حسب نوع المستخدم.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (backpack_auth()->guest()) {
            return $this->respondToUnauthorizedRequest($request);
        }

        if (! $this->checkIfUserIsAdmin(backpack_user())) {
            return $this->respondToForbiddenRequest($request);
        }

        $user = backpack_user();
        if ($user !== null && $user->isDistributor()) {
            if (! $this->isDistributorAllowedRequest($request)) {
                return $this->respondToForbiddenRequest($request);
            }
        }

        return $next($request);
    }
}
