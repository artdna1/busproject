<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        return view('dashboard'); // no more compact('bookings')
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
        ]);

        $trip = Trip::findOrFail($validated['trip_id']);

        $alreadyBooked = Booking::where('user_id', auth()->id())
            ->where('trip_id', $trip->id)
            ->exists();

        if ($alreadyBooked) {
            return back()->withErrors(['trip_id' => 'You already booked this trip.']);
        }

        Booking::create([
            'user_id' => auth()->id(),
            'trip_id' => $trip->id,
            'origin' => $trip->origin,
            'destination' => $trip->destination,
            'travel_date' => $trip->travel_date,
            'travel_time' => $trip->travel_time,
        ]);

        return redirect()->back()->with('success', 'Bus booked successfully!');
    }

    public function destroy($id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);
        $booking->delete();

        return redirect()->route('dashboard')->with('success', 'Booking cancelled.');
    }
}
