<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = auth()->user()->bookings()->latest()->get();
        return view('dashboard', compact('bookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255|different:origin',
            'travel_date' => 'required|date|after_or_equal:today',
            'travel_time' => 'required',
        ], [
            'destination.different' => 'Origin and Destination must be different.',
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
