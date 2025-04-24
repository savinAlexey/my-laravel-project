<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            // Редирект в зависимости от guard-а
            return match ($guard) {
                'admin' => redirect()->route('admin.dashboard'),
                default => redirect()->route('account.dashboard'),
            };
        }

        return $next($request);
    }
}
