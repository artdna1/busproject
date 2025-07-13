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

         // app/Http/Middleware/EnsureUserIsAdmin.php
if ($user && $user->role !== 'super_admin' && $user->status !== 'approved') {
    Auth::logout();
    abort(403, 'Your account is not yet approved.');
}



        return $next($request);
    }
}
