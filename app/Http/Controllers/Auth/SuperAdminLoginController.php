<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class SuperAdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.super-admin-login'); // create this Blade view
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user->role !== 'super_admin') {
            Auth::logout();
            return redirect()->back()->withErrors(['email' => 'Access denied. Not a Super Admin.']);
        }

        return redirect()->route('super-admin.dashboard');
    }

    return redirect()->back()->withErrors(['email' => 'Invalid login credentials.']);
}

    public function logout()
    {
        Auth::logout();
        return redirect()->route('super-admin.login');
    }
}
