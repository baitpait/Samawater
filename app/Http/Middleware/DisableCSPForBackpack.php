<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * تعطيل Content Security Policy للصفحات التي تحتاج eval()
 * مثل DataTables و Backpack CRUD
 */
class DisableCSPForBackpack
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // إزالة CSP headers إذا كانت موجودة
        $response->headers->remove('Content-Security-Policy');
        $response->headers->remove('X-Content-Security-Policy');
        $response->headers->remove('X-WebKit-CSP');

        // أو إضافة CSP مع unsafe-eval للصفحات الإدارية فقط
        if ($request->is('admin/*')) {
            $csp = "default-src 'self'; " .
                   "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://cdn.datatables.net https://fonts.googleapis.com; " .
                   "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://cdn.datatables.net https://fonts.googleapis.com https://maxst.icons8.com; " .
                   "font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com data:; " .
                   "img-src 'self' data: https:; " .
                   "connect-src 'self' http://127.0.0.1:* http://localhost:* https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://cdn.datatables.net;";
            $response->headers->set('Content-Security-Policy', $csp);
        }

        return $response;
    }
}
