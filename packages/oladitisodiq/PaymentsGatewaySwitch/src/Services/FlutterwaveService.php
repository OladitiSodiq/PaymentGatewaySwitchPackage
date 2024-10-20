<?php

namespace PaymentsGatewaySwitch\Services;

use PaymentsGatewaySwitch\Response\PaymentResponse;

class FlutterwaveService
{
    public function isAvailable()
    {

        // dd(  config('config.gateways.flutterwave.status'));
        return config('config.gateways.flutterwave.status') === 'active';
        //availability will be if there is downtime form flutterwave.
        //this will be done through connecting to flutterwaveee  ApI

          //DUE TO time and availability of keys to test normall for the api , i decided to fix this up from the env file down to the config.
       
    }
    public function getName()
    {
        return 'FlutterwaveService ';
    }

    public function checkBalance()
    {
        // Implement logic to check Flutterwave's balance.

        // this logic will be from flutterwave api to check for balance for the organization and it will return the balance amount.
        //Note:: The amount must tally with what is on the dashboard while accessing through flutterwave dashboard.
        return 5000;
    }

    public function supportsCurrency($currency)
    {
        // Example: Flutterwave supports NGN, GHS, KES, USD
        return in_array($currency, ['NGN', 'GHS', 'KES', 'USD']);
    }
    public function getChargePercentage()
    {
        return 2.5;
         // Note: charges are meant to come from thr api calls too 
    }

    public function pay(array $data)
    {
        
        return new PaymentResponse(
            'Flutterwave',
            config('config.gateways.flutterwave.api_url'),
            config('config.gateways.flutterwave.api_key'),
            $data['total_amount'],
            $data['charge'],
            true,
            'Payment successful via Flutterwave.'
        );
    }
}