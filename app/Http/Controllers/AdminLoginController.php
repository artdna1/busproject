<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Handle admin login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = auth()->user();

            if (!in_array($user->role, ['admin', 'super_admin'])) {
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Access denied: You are not an admin.',
                ]);
            }

            if ($user->status !== 'approved') {
                Auth::logout();
                return redirect()->route('admin.login')->withErrors([
                    'email' => 'Your account is not yet approved by a Company.',
                ]);
            }

            return redirect('/admin'); // Redirect to admin dashboard
        }

        // Invalid login
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }
}
