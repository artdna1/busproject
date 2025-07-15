<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\TripSearchController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// ✅ Welcome Page
Route::get('/', fn() => view('welcome'));

// ✅ Admin Registration/Login (Not handled by Filament)
Route::middleware('guest')->group(function () {
    Route::get('/admin/register', [AdminRegisterController::class, 'showRegistrationForm'])->name('admin.register');
    Route::post('/admin/register', [AdminRegisterController::class, 'register'])->name('admin.register.submit');
    Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
});

// ✅ Email Verification (for users only)
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', fn() => view('auth.verify-email'))->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return in_array($request->user()->role, ['admin', 'super_admin'])
            ? redirect('/admin')
            : redirect()->route('dashboard');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->name('verification.send');
});

// ✅ User Routes (Only if email verified)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [BookingController::class, 'index'])->name('dashboard');
    Route::get('/search-trips', [TripSearchController::class, 'showForm'])->name('trips.search');
    Route::get('/search-trips/results', [TripSearchController::class, 'search'])->name('trips.search.results');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::get('/my-bookings', [BookingController::class, 'list'])->name('bookings.list');
});
