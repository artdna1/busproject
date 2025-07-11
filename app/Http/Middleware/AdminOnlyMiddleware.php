<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminOnlyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('admin/login') || $request->is('admin/login/*')) {
            return $next($request);
        }

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        \Log::info('Authenticated user:', [
            'id' => Auth::id(),
            'roles' => Auth::user()->getRoleNames()->toArray(),
        ]);

        if (!Auth::user()->hasAnyRole(['admin', 'super-admin'])) {
            abort(403);
        }

        return $next($request);
    }
}
