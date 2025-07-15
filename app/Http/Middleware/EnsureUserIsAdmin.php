<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (
            !$user ||
            !in_array($user->role, ['admin', 'super_admin']) ||
            ($user->role === 'admin' && $user->status !== 'approved')
        ) {
            Auth::logout();
            abort(403, 'Access denied: Admin approval required.');
        }

        return $next($request);
    }
}
