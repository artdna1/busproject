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
        // ✅ Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // ✅ Attempt login
        $credentials = $request->only('email', 'password');

       if (Auth::attempt($credentials)) {
    $request->session()->regenerate();

    if (auth()->user()->role === 'admin' && auth()->user()->status !== 'approved') {
        Auth::logout();
        return redirect()->route('admin.login')->withErrors([
            'email' => 'Your account is not yet approved by a Company',
        ]);
    }

    return redirect()->intended('/admin/dashboard');
}
        // ❌ Invalid login attempt
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }
}
