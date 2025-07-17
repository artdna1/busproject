<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Booking;
use App\Services\PayPalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayPalController extends Controller
{
    protected $paypal;

    public function __construct(PayPalService $paypal)
    {
        $this->paypal = $paypal;
    }

    public function pay(Request $request, $tripId)
    {
        $trip = Trip::findOrFail($tripId);
        $order = $this->paypal->createOrder($trip->price);

        session([
            'trip_id' => $trip->id
        ]);

        return redirect()->away($order['links'][1]['href']);
    }

    public function success(Request $request)
    {
        $tripId = session('trip_id');
        $trip = Trip::findOrFail($tripId);

        $payment = $this->paypal->captureOrder($request->token);

        Booking::create([
            'user_id' => Auth::id(),
            'trip_id' => $trip->id,
            'status' => 'approved',
            'payment_status' => 'verified',
        ]);

        return redirect('/dashboard')->with('success', 'Payment successful. Trip booked!');
    }

    public function cancel()
    {
        return redirect('/dashboard')->with('error', 'Payment cancelled.');
    }
}
