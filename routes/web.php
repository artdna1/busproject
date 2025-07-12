<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Controllers\Auth\AdminRegisterController;

// Show the registration form
Route::get('/admin/register', [AdminRegisterController::class, 'showRegistrationForm'])->name('admin.register');

// Handle form submission
Route::post('/admin/register', [AdminRegisterController::class, 'register'])->name('admin.register.submit');

/**
 * Public routes
 */
Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);

/**
 * Admin dashboard - protected by custom middleware
 */
Route::middleware(['auth', EnsureUserIsAdmin::class])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

/**
 * Regular user dashboard
 */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [BookingController::class, 'index'])->name('dashboard');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');
});
