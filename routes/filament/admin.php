<?php

use Illuminate\Support\Facades\Route;
use Filament\Pages\Dashboard;

Route::get('/', Dashboard::class)->name('filament.admin.pages.dashboard');

Route::get('/custom-welcome', function () {
    return 'Welcome to the custom admin panel!';
});
