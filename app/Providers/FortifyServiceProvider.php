<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Fortify;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Validation\ValidationException;

class FortifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind user registration logic
        $this->app->singleton(CreatesNewUsers::class, CreateNewUser::class);

        // ✅ Custom login redirect based on role
        $this->app->booted(function () {
            $this->app->singleton(LoginResponse::class, function () {
                return new class implements LoginResponse {
                    public function toResponse($request)
                    {
                        $user = $request->user();

                        if ($user->hasRole('admin') || $user->hasRole('super_admin')) {
                            return redirect('/admin'); // You can also use route('admin.dashboard') if defined
                        }

                        return redirect()->route('dashboard');
                    }
                };
            });
        });
    }

    public function boot(): void
    {
        // ✅ Load custom login view
        Fortify::loginView(fn() => view('auth.login'));

        // ✅ Custom authentication with reCAPTCHA
        Fortify::authenticateUsing(function (Request $request) {
            Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
                'g-recaptcha-response' => 'required|captcha',
            ])->validate();

            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }

            return null;
        });

        // ✅ Rate limiting for login
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email . '|' . $request->ip());
        });
    }
}
