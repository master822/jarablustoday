<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class EnvironmentCheck
{
    public function handle(Request $request, Closure $next)
    {
        // في بيئة الإنتاج، تأكد من أن DEBUG = false
        if (App::environment('production') && config('app.debug') === true) {
            abort(500, 'Application debug mode is not allowed in production.');
        }
        
        return $next($request);
    }
}
