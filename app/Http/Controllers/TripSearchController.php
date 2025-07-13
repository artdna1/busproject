<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Booking;

class TripSearchController extends Controller
{
    public function showForm()
    {
        $bookings = Booking::where('user_id', auth()->id())->latest()->get();
        return view('search-trips', compact('bookings'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255|different:origin',
            'travel_date' => 'required|date|after_or_equal:today',
            'travel_time' => 'required|date_format:H:i',
        ]);

        $bookings = \App\Models\Booking::where('user_id', auth()->id())->latest()->get();

        // Exact match
        $exactMatches = Trip::where('origin', $request->origin)
            ->where('destination', $request->destination)
            ->whereDate('travel_date', $request->travel_date)
            ->whereTime('travel_time', $request->travel_time)
            ->get();

        if ($exactMatches->count() > 0) {
            return view('trip-results', [
                'trips' => $exactMatches,
                'message' => 'Showing exact matching trips.',
                'bookings' => $bookings,
            ]);
        }

        // Fallback: all trips on the same date
        $dateMatches = Trip::whereDate('travel_date', $request->travel_date)->get();

        if ($dateMatches->count() > 0) {
            return view('trip-results', [
                'trips' => $dateMatches,
                'message' => 'No exact match. Showing all available trips on selected date.',
                'bookings' => $bookings,
            ]);
        }

        // No trips at all
        return view('trip-results', [
            'trips' => collect(),
            'message' => 'No available trips found for that date.',
            'bookings' => $bookings,
        ]);
    }
}
