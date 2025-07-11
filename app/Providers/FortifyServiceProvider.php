<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Fortify;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class FortifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Throttle login attempts
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email . $request->ip());
        });

        // Custom login view (optional)
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // Role-based login redirection
        $this->app->singleton(LoginResponseContract::class, function () {
            return new class implements LoginResponseContract {
                public function toResponse($request)
                {
                    $user = $request->user();

                    \Log::info('Redirecting user after login', [
                        'user_id' => $user->id,
                        'roles' => $user->getRoleNames(),
                    ]);

                    if ($user->hasRole('super-admin') || $user->hasRole('admin')) {
                        return redirect('/admin');
                    }

                    return redirect('/dashboard');
                }
            };
        });
    }
}
