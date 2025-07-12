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
}
