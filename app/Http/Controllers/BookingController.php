<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Show the dashboard with available trips.
     */
    public function index()
{
    $now = Carbon::now();

    $trips = Trip::whereDate('travel_date', $now->toDateString())
                ->whereTime('travel_time', '>=', $now->toTimeString())
                ->orderBy('travel_time')
                ->withCount(['bookings as approved_bookings_count' => function ($query) {
                    $query->where('status', 'approved');
                }])
                ->get();

    return view('dashboard', compact('trips'));
}





    /**
     * Handle booking submission.
     */
  public function store(Request $request)
{
    $request->validate([
        'trip_id' => 'required|exists:trips,id',
        'seat_number' => 'required|string',
        'payment_method' => 'required|in:GCash,BankTransfer,PayMaya,ShopeePay,GrabPay,Coins.ph',
    ]);

    $trip = Trip::findOrFail($request->trip_id);
    $userId = Auth::id();

    $alreadyBooked = Booking::where('user_id', $userId)
        ->where('trip_id', $trip->id)
        ->exists();

    if ($alreadyBooked) {
        return back()->withErrors(['trip_id' => 'You already booked this trip.']);
    }

    $seatAlreadyTaken = Booking::where('trip_id', $trip->id)
        ->where('seat_number', $request->seat_number)
        ->where('status', 'approved')
        ->exists();

    if ($seatAlreadyTaken) {
        return back()->withErrors(['seat_number' => 'That seat is already taken.']);
    }

   $approvedCount = $trip->bookings()->where('status', 'approved')->count();

    $seatsLeft = $trip->seat_capacity - $approvedCount;

    if ($seatsLeft < 1) {
        return back()->withErrors(['trip_id' => 'Sorry, no more seats available for this trip.']);
    }

    Booking::create([
        'user_id' => $userId,
        'trip_id' => $trip->id,
        'origin' => $trip->origin,
        'destination' => $trip->destination,
        'travel_date' => $trip->travel_date,
        'travel_time' => $trip->travel_time,
        'seat_number' => $request->seat_number,
        'status' => 'pending',
        'payment_method' => $request->payment_method,
        'payment_status' => 'pending',
    ]);

     return redirect()->route('bookings.list')->with('success', 'Booking submitted! Waiting for admin verification.');
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
