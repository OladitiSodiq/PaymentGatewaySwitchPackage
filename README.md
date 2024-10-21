

## Payment Gateway Switch Package Documentation

## Table of Contents
1. [Introduction](#introduction)
2. [Installation](#installation)
3. [Configuration](#configuration)
4. [Usage](#usage)
5. [Use Cases](#use-cases)
<!-- 6. [Testing](#testing)
7. [License](#license) -->

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

### Use Case Examples

1. Payment Gateway is Unavailable

    A user wants to pay 10,000 NGN from Nigeria.
        
    The package will check isAvailable() status and balance for Paystack first. Since Paystack meets all conditions, the payment is processed through Paystack.


2. Payment Gateway Balance is insufficient 

    A user wants to pay 20,000 NGN from Nigeria.

    paystack balance:10,000 NGN

    flutterwave balance : 40,000 NGN

    Paystack is checked first but it has insufficient balance, so the package logs this and continues with Flutterwave, to processes the payment.


3. Payment Gateway is Unavailable based on location 

    A user wants to pay 50 usd from the United state.

    Paystack: USD not supported
    Flutterwave: Supported foriegn payment.

    Paystack is skipped due to Flutterwave support forign payment.

3. No Suitable Gateway Available

    A user tries to pay 100 INR (India Rupee).

    Paystack: Active, balance sufficient, but does not support INR.
    Flutterwave: Active, but also does not support INR.
     The package iterates through each gateway but finds no support for INR, resulting in an exception: "No suitable payment gateway available."


### Example Request

```http 
POST: /api/pay
Host: yourwebsite.com or Localhost
Content-Type: application/json

{
    "amount": 5000,
    "location": "Nigeria",
}
```

### Example Response 

```
    {
        "provider": "Paystack",
        "apiUrl": "https:\/\/api.paystack.co",
        "apiKey": "your_paystack_api_key",
        "status": true,
        "message": "Payment successful via Paystack.",
        "amount": 5175,
        "charges": 3.5
    }
```





