<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        Log::info('Logged-in user:', [
            'id' => optional($user)->id,
            'email' => optional($user)->email,
            'role' => optional($user)->role,
        ]);

        if (! $user || !in_array($user->role, ['admin', 'super_admin'])) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
