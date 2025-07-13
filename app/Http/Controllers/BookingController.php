<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function list()
    {
        $bookings = Booking::where('user_id', Auth::id())->latest()->get();
        return view('my-bookings', compact('bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
        ]);

        $trip = Trip::findOrFail($request->trip_id);

        $userId = Auth::id();

        $alreadyBooked = Booking::where('user_id', $userId)
            ->where('trip_id', $trip->id)
            ->exists();

        if ($alreadyBooked) {
            return back()->withErrors(['trip_id' => 'You already booked this trip.']);
        }

        Booking::create([
            'user_id' => $userId,
            'trip_id' => $trip->id,
            'origin' => $trip->origin,
            'destination' => $trip->destination,
            'travel_date' => $trip->travel_date,
            'travel_time' => $trip->travel_time,
        ]);

        return back()->with('success', 'Bus booked successfully!');
    }

    public function destroy($id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);
        $booking->delete();

        return redirect()->route('bookings.list')->with('success', 'Booking cancelled.');
    }
}
