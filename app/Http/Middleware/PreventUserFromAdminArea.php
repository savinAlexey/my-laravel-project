<?php

namespace App\Http\Middleware;

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PreventUserFromAdminArea
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('web')->check()) {
            abort(403, 'Users cannot access admin routes.');
        }

        return $next($request);
    }
}

