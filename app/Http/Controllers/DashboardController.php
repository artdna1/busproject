<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $trips = Trip::withCount([
            'bookings as approved_bookings_count' => function ($query) {
                $query->where('status', 'approved');
            }
        ])
        ->with(['bookings' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])
        ->orderBy('travel_date')
        ->get();

        return view('dashboard', compact('trips'));
    }
}
