<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())->latest()->get();
        return view('dashboard', compact('bookings'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255|different:origin',
            'travel_date' => 'required|date|after_or_equal:today',
            'travel_time' => 'required|date_format:H:i',
        ]);

        // Optional validation: 24hr advance booking
        $bookingDateTime = Carbon::parse($validated['travel_date'] . ' ' . $validated['travel_time']);
        if ($bookingDateTime->lt(now()->addDay())) {
            return back()->withErrors([
                'travel_time' => 'Bookings must be at least 24 hours in advance.',
            ])->withInput();
        }

        $validated['user_id'] = Auth::id();
        Booking::create($validated);

        return redirect()->route('dashboard')->with('success', 'Booking created successfully.');
    }

    public function destroy($id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);
        $booking->delete();

        return redirect()->route('dashboard')->with('success', 'Booking cancelled.');
    }
}
