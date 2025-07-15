<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Auth;

class RedirectAuthenticatedUsers
{
    public function __invoke()
    {
        $user = Auth::user();

        if ($user->role === 'admin' || $user->role === 'super_admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard');
    }
}
