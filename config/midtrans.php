<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the configuration for Midtrans payment gateway.
    |
    */

    // Set to true for production environment, false for sandbox/development
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    // Your merchant credentials
    'server_key' => env('MIDTRANS_SERVER_KEY', ''),
    'client_key' => env('MIDTRANS_CLIENT_KEY', ''),

    // Optional: Midtrans Snap API base URL
    'snap_url' => env('MIDTRANS_IS_PRODUCTION', false)
        ? 'https://app.midtrans.com/snap/v1/transactions'
        : 'https://app.sandbox.midtrans.com/snap/v1/transactions',

    // Optional: Midtrans API base URL
    'api_url' => env('MIDTRANS_IS_PRODUCTION', false)
        ? 'https://api.midtrans.com'
        : 'https://api.sandbox.midtrans.com',
];
