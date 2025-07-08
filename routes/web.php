<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return view('welcome');
});

// ✅ Secure group for authenticated users
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // ✅ Dashboard handled by BookingController
    Route::get('/dashboard', [BookingController::class, 'index'])->name('dashboard');

    // ✅ Create booking
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

    // ✅ Delete booking
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');
});
