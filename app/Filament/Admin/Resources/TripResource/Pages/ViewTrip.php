<?php

namespace App\Filament\Admin\Resources\TripResource\Pages;

use App\Filament\Admin\Resources\TripResource;
use Filament\Resources\Pages\ViewRecord;

class ViewTrip extends ViewRecord
{
    protected static string $resource = TripResource::class;

    protected function getViewData(): array
    {
        return [
            'bookings' => $this->record->bookings()->with('user')->get(),
        ];
    }
}
