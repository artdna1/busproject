<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;

class PayPalController extends Controller
{
    public function checkout(Request $request, Trip $trip)
    {
        $request->validate([
            'seat_number' => 'required|string',
        ]);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success'),
                "cancel_url" => route('paypal.cancel'),
            ],
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => "PHP",
                    "value" => number_format($trip->price, 2, '.', ''),
                ],
                "description" => "Bus Trip from {$trip->origin} to {$trip->destination} - Seat {$request->seat_number}",
            ]],
        ]);

        if (isset($response['id']) && $response['status'] === 'CREATED') {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    // Store booking as pending with payment_method = PayPal here if you want before redirecting
                    return redirect()->away($link['href']);
                }
            }
        }

        return back()->with('error', 'Unable to initiate PayPal payment.');
    }

    // You need to create success and cancel routes and methods accordingly
    public function success(Request $request)
    {
        // Handle payment capture and booking confirmation here
        // Example: capture payment, update booking status, show success page
    }

    public function cancel()
    {
        return redirect()->route('dashboard')->with('error', 'You cancelled the PayPal payment.');
    }
}
