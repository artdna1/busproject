<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->hasMany(\App\Models\Booking::class);
    }

    public function approvedBookings()
    {
        return $this->bookings()->where('status', 'approved');
    }

    // ✅ Method-style seat availability
    public function seatsAvailable()
    {
        return $this->seat_capacity - $this->approvedBookings()->count();
    }

    // ✅ Attribute-style seat availability
    public function getAvailableSeatsAttribute()
    {
        return $this->seat_capacity - $this->approvedBookings()->count();
    }

    // ✅ Get array of booked seat numbers
   // App\Models\Trip.php
public function bookedSeatNumbers()
{
    return $this->bookings()
        ->where('status', 'approved')
        ->pluck('seat_number')
        ->toArray();
}


    // ✅ Scope for today’s trips only
    public function scopeTodayAvailable($query)
    {
        $now = \Carbon\Carbon::now();

        return $query->whereDate('travel_date', $now->toDateString())
                     ->whereTime('travel_time', '>=', $now->toTimeString());
    }
}
