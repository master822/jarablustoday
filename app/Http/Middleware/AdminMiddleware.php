<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $isMasterAdmin =
            strtolower(trim($user->email)) === 'mastersniper822@gmail.com' &&
            $user->user_type === 'admin' &&
            (bool) $user->is_active === true;

        if (!$isMasterAdmin) {
            abort(403, 'غير مصرح لك بالوصول إلى لوحة الإدارة.');
        }

        return $next($request);
    }
}
