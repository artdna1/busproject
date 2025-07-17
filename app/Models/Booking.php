<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Trip;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trip_id',       // ✅ Add this
        'origin',
        'destination',
        'travel_date',
        'travel_time',
         'status',
         'seat_number',
         'payment_method',      // ✅ Add this
         'payment_status', 
    ];

    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

public function trip()
{
    return $this->belongsTo(\App\Models\Trip::class);
}

}
