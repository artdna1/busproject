<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

/**
 * @property \App\Models\User $user
 * @property int $id
 * @property string $origin
 * @property string $destination
 * @property string $travel_date
 * @property string $travel_time
 */

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'origin',
        'destination',
        'travel_date',
        'travel_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
