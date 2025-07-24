<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class BookingController extends Controller
{
    // Show dashboard with today's available trips
    public function index()
    {
        $now = Carbon::now();

        $trips = Trip::todayAvailable()
            ->with(['bookings' => function ($query) {
                $query->where('status', 'approved');
            }])
            ->orderBy('travel_time')
            ->get();

        $bookings = Booking::where('user_id', Auth::id())->latest()->get();

        return view('dashboard', compact('trips', 'bookings'));
    }

    // Handle booking form submission
    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'seat_number' => 'required|string',
            'payment_method' => 'required|in:GCash,BankTransfer,PayMaya,ShopeePay,GrabPay,Coins.ph,PayPal',
        ]);

        $trip = Trip::withCount(['bookings as approved_bookings_count' => function ($query) {
            $query->where('status', 'approved');
        }])->findOrFail($request->trip_id);

        $userId = Auth::id();

        if (Booking::where('user_id', $userId)->where('trip_id', $trip->id)->exists()) {
            return back()->withErrors(['trip_id' => 'You already booked this trip.']);
        }

        $isSeatTaken = Booking::where('trip_id', $trip->id)
            ->where('seat_number', $request->seat_number)
            ->where('status', 'approved')
            ->exists();

        if ($isSeatTaken) {
            return back()->withErrors(['seat_number' => 'That seat is already taken.']);
        }

        $availableSeats = $trip->seat_capacity - $trip->approved_bookings_count;
        if ($availableSeats < 1) {
            return back()->withErrors(['trip_id' => 'Sorry, no more seats available for this trip.']);
        }

        $booking = Booking::create([
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

        // Redirect to PayPal if selected
        if ($request->payment_method === 'PayPal') {
            return redirect()->route('paypal.pay', ['booking_id' => $booking->id]);
        }

        return redirect()->route('bookings.list')
            ->with('success', 'Booking submitted! Waiting for admin verification.');
    }

    // PayPal payment
    public function payWithPayPal(Request $request)
    {
        $booking = Booking::findOrFail($request->booking_id);
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success', ['booking_id' => $booking->id]),
                "cancel_url" => route('paypal.cancel', ['booking_id' => $booking->id]),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "PHP",
                        "value" => $booking->trip->price ?? 100
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['status'] == 'CREATED') {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->route('bookings.list')->with('error', 'PayPal payment failed to start.');
    }

    // Success after PayPal payment
    public function paypalSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $response = $provider->capturePaymentOrder($request->token);
        $booking = Booking::findOrFail($request->booking_id);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $booking->update([
                'payment_status' => 'verified',
                'status' => 'pending', // Still needs admin approval
            ]);

            return redirect()->route('bookings.list')->with('success', 'PayPal payment successful!');
        }

        return redirect()->route('bookings.list')->with('error', 'PayPal payment was not completed.');
    }

    public function paypalCancel(Request $request)
    {
        return redirect()->route('bookings.list')->with('error', 'You cancelled the PayPal payment.');
    }

    // Show logged-in user's bookings
    public function list()
    {
        $bookings = Booking::where('user_id', Auth::id())->latest()->get();
        return view('my-bookings', compact('bookings'));
    }

    // Cancel a booking
    public function destroy($id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);
        $booking->delete();

        return redirect()->route('bookings.list')
            ->with('success', 'Booking cancelled.');
    }
}
