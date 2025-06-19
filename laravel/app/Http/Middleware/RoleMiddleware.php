<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (session('role') !== $role) {
            return redirect('/login.login')->with('error', 'غير مصرح لك بالدخول');
        }

        return $next($request);
    }
}
