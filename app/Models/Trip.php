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
     public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function seatsAvailable()
    {
        // Count approved bookings only
        $bookedSeats = $this->bookings()->where('status', 'approved')->count();

        return $this->seat_capacity - $bookedSeats;
    }
    public function getAvailableSeatsAttribute()
{
    $bookedSeats = $this->bookings()->where('status', 'approved')->count();
    return $this->seat_capacity - $bookedSeats;
}

}
