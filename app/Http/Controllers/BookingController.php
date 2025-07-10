<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Trip;

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
            'trip_id' => 'required|exists:trips,id',
        ]);

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
