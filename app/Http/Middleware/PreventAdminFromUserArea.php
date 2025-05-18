<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PreventAdminFromUserArea
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            abort(403, 'Admins cannot access account routes.');
        }

        return $next($request);
    }
}
