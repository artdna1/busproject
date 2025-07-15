<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Fortify;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use App\Actions\Fortify\CreateNewUser;
use Filament\Facades\Filament;

class FortifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CreatesNewUsers::class, CreateNewUser::class);

        // ✅ Delayed LoginResponse binding
        $this->app->booted(function () {
            $this->app->singleton(LoginResponse::class, function () {
                return new class implements LoginResponse {
                    public function toResponse($request)
                    {
                        $user = $request->user();

                        if ($user->hasRole('admin') || $user->hasRole('super_admin')) {
                            return redirect('/admin');
                        }

                        return redirect()->route('dashboard');
                    }
                };
            });
        });
    }

    public function boot(): void
    {
        Fortify::loginView(fn() => view('auth.login'));

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email . '|' . $request->ip());
        });
    }
}
