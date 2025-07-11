<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Trip;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = auth()->user()->bookings()->latest()->get();
        $trips = Trip::orderBy('travel_date')->get(); // fetch trips
        return view('dashboard', compact('bookings', 'trips'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255|different:origin',
            'travel_date' => 'required|date|after_or_equal:today',
            'travel_time' => 'required|date_format:H:i',
        ]);

        // Check if travel_date is today and time is in the past
        $bookingDateTime = Carbon::parse($validated['travel_date'] . ' ' . $validated['travel_time']);
        $minimumBookingTime = now()->addDay();

        if ($bookingDateTime->lt($minimumBookingTime)) {
            return back()->withErrors([
                'travel_time' => 'Bookings must be made at least 24 hours in advance.'
            ])->withInput();
        }


        $validated['user_id'] = auth()->id();

        auth()->user()->bookings()->create($validated);

        return redirect()->route('dashboard')->with('success', 'Booking created successfully.');
    }

    public function destroy($id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);
        $booking->delete();

        return redirect()->route('dashboard')->with('success', 'Booking cancelled.');
    }
}
