<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Show the dashboard with available trips.
     */
    public function index()
    {
        $trips = Trip::orderBy('travel_date')->get(); // Load all trips
        return view('dashboard', compact('trips'));
    }

    /**
     * Handle booking submission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
        ]);

        $trip = Trip::findOrFail($request->trip_id);
        $userId = Auth::id();

        // Log booking attempt
        \Log::info('Booking attempt by user ID: ' . $userId);
        \Log::info('Trip info: ', $trip->toArray());

        // Check if already booked
        $alreadyBooked = Booking::where('user_id', $userId)
            ->where('trip_id', $trip->id)
            ->exists();

        if ($alreadyBooked) {
            return back()->withErrors(['trip_id' => 'You already booked this trip.']);
        }

        // Use seatsAvailable() method to check availability
        if ($trip->seatsAvailable() < 1) {
            return back()->withErrors(['trip_id' => 'Sorry, no more seats available for this trip.']);
        }

        // Create booking
        Booking::create([
            'user_id' => $userId,
            'trip_id' => $trip->id,
            'origin' => $trip->origin,
            'destination' => $trip->destination,
            'travel_date' => $trip->travel_date,
            'travel_time' => $trip->travel_time,
            'status' => 'pending',
        ]);

        // Log success
        \Log::info('Booking created successfully for user ID: ' . $userId);

        return redirect()->route('bookings.list')->with('success', 'Bus booked successfully!');
    }

    /**
     * Show list of the logged-in user's bookings.
     */
    public function list()
    {
        $bookings = Booking::where('user_id', Auth::id())->latest()->get();
        return view('my-bookings', compact('bookings'));
    }

    /**
     * Cancel (delete) a booking.
     */
    public function destroy($id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);

        // No need to manually increment seats_available, as availability is dynamic

        $booking->delete();

        return redirect()->route('bookings.list')->with('success', 'Booking cancelled.');
    }
}
