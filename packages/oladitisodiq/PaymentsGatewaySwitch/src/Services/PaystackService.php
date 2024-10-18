<?php


namespace PaymentsGatewaySwitch\Services;

use PaymentsGatewaySwitch\Response\PaymentResponse;

class PaystackService
{
    public function isAvailable()
    {
        return config('config.gateways.paystack.status') === 'active';
          //availability will be if there is downtime form flutterwave.
            //this will be done through connecting to flutterwaveee  ApI


            //DUE TO time and availability of keys to test normall for the api , i decided to fix this up from the env file down to the config.
    }

    public function getName()
    {
        return 'Paystack';
    }
    public function checkBalance()
    {
         // Implement logic to check Flutterwave's balance.

        // this logic will be from flutterwave api to check for balance for the organization and it will return the balance amount.
        //Note:: The amount must tally with what is on the dashboard while accessing through flutterwave dashboard.
        return 10000;
    }

    public function supportsCurrency($currency)
    {
        // Example: Paystack supports NGN, USD
        return in_array($currency, ['NGN']);
    }

    public function pay(array $data)
    {
      
        return new PaymentResponse(
            'Paystack',
            config('config.gateways.paystack.api_url'),
            config('config.gateways.paystack.api_key'),
            true,
            'Payment successful via Paystack.'
        );
    }
}
