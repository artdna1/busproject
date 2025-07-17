<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Booking;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin',
        'destination',
        'bus_name',
        'travel_date',
        'travel_time',
        'seat_capacity',
        'price',
    ];

    // Relationships
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function approvedBookings()
    {
        return $this->bookings()->where('status', 'approved');
    }

    // Accessors / Helpers
    public function seatsAvailable()
    {
        return $this->seat_capacity - $this->approvedBookings()->count();
    }

    public function getAvailableSeatsAttribute()
    {
        return $this->seatsAvailable(); // Reuse method for consistency
    }

    public function bookedSeatNumbers()
    {
        return $this->approvedBookings()
            ->pluck('seat_number')
            ->toArray();
    }

    // Query Scope
    public function scopeTodayAvailable($query)
    {
        $now = Carbon::now();

        return $query->whereDate('travel_date', $now->toDateString())
            ->whereTime('travel_time', '>=', $now->toTimeString());
    }
}
