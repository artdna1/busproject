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
        'travel_date',
        'travel_time',
        'bus_name',
        // add other fields you want to manage
    ];
}
