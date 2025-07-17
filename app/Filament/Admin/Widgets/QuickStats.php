<?php

namespace App\Filament\Admin\Widgets;

use App\Models\User;
use App\Models\Booking;
use App\Models\Trip;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class QuickStats extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getCards(): array
    {
        return [
            Card::make('Total Users', User::count()),
            Card::make('Total Bookings', Booking::count()),
            Card::make('Total Trips', Trip::count()),
        ];
    }
}
