<?php

namespace App\Http\Controllers;

use App\Models\Trip;

class AdminTripController extends Controller
{
    public function showTrips()
    {
        $trips = Trip::orderBy('travel_date')->get();
        return view('admin.trips', compact('trips'));
    }
}
