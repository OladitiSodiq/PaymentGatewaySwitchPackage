

## Payment Gateway Switch Package Documentation

## Table of Contents
1. [Introduction](#introduction)
2. [Installation](#installation)
3. [Configuration](#configuration)
4. [Usage](#usage)
5. [Use Cases](#use-cases)
6. [Testing](#testing)
7. [License](#license)

---

## Introduction
The `PaymentsGatewaySwitch` package allows easy switching between two different payment gatewayswhich are fluuterwaveand paystack based on configurable rules. It automatically selects the best available gateway based on criteria such as availability, balance, and currency compatibility.

## Installation

### Step 1: Install via Composer
You can install the package using Composer. Run the following command in your Laravel project directory:

```bash
composer require oladitisodiq/PaymentsGatewaySwitch

```

### Configuration
Open the config/config.php file to configure your payment gateways:

```php

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

```

### Environment Variables
Make sure to add the following variables to your .env file:

```.env

    PAYSTACK_API_KEY=your_paystack_api_key
    PAYSTACK_API_URL=https://api.paystack.co
    PAYSTACK_STATUS=active //inactive for not available

    FLUTTERWAVE_API_KEY=your_flutterwave_api_key
    FLUTTERWAVE_API_URL=https://api.flutterwave.com
    FLUTTERWAVE_STATUS=active //inactive for not available


```


### Usage
Step 1: Use the Facade
You can use the PaymentsGatewaySwitch facade to initiate payments. Here’s how to use it in a controller:

```php 
        namespace App\Http\Controllers;

        use Illuminate\Http\Request;
        use PaymentsGatewaySwitch\Facades\PaymentsGatewaySwitch;

        class PaymentController extends Controller
        {
            //
            public function processPayment(Request $request)
            {

                // dd("isisjs");
                $data = [
                    'amount' => $request->input('amount'),
                    'location' => $request->input('location'),
                ];

                try {
                    $response = PaymentsGatewaySwitch::pay($data);
                    return response()->json($response);
                } catch (\Exception $e) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
                }
            }
        }
```

Step 2: Route Definition
Define a route to handle payment processing in your routes/api.php file: to test using postman or insomnia

```php api
    Route::post('/pay', [PaymentController::class, 'processPayment']);
```

## Use Case Examples
1. Payment Gateway is Unavailable
1. Payment Gateway Balance is insufficient 
1. Payment Gateway is Unavailable based on location 


