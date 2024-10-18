
<?php

return [
    'default_currency' => env('PAYMENT_DEFAULT_CURRENCY', 'NGN'),

    'gateways' => [
        'paystack' => [
            'api_provider_name' => 'Paystack',
            'api_url' => env('PAYSTACK_API_URL', 'https://api.paystack.co'),
            'api_key' => env('PAYSTACK_API_KEY', 'your_paystack_api_key'),
            'status' => env('PAYSTACK_STATUS', 'active'),
        ],

        'flutterwave' => [
            'api_provider_name' => 'Flutterwave',
            'api_url' => env('FLUTTERWAVE_API_URL', 'https://api.flutterwave.com'),
            'api_key' => env('FLUTTERWAVE_API_KEY', 'your_flutterwave_api_key'),
            'status' => env('FLUTTERWAVE_STATUS', 'active'),
        ],
    ],

    'location_currency_mapping' => [
        'Nigeria' => 'NGN',
        'United States' => 'USD',
        'Ghana' => 'GHS',
        'Kenya' => 'KES',
      
    ],
];
