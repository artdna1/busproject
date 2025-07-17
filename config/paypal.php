<?php

return [

    'mode' => env('PAYPAL_MODE', 'sandbox'), // Can be 'sandbox' or 'live'

    'sandbox' => [
        'client_id' => env('PAYPAL_CLIENT_ID', ''),
        'client_secret' => env('PAYPAL_SECRET', ''),
        'app_id' => '', // optional
    ],

    'live' => [
        'client_id' => env('PAYPAL_CLIENT_ID', ''),
        'client_secret' => env('PAYPAL_SECRET', ''),
        'app_id' => '', // optional
    ],

    'payment_action' => 'Sale', // Can be 'Sale', 'Authorization', 'Order'
    'currency' => 'USD',
    'notify_url' => '', // Can leave blank or set to your IPN route
    'locale' => 'en_US',
    'validate_ssl' => true, // Set to false only for local testing
];
