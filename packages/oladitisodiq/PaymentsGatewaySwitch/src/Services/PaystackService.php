<?php


namespace PaymentsGatewaySwitch\Services;

use PaymentsGatewaySwitch\Response\PaymentResponse;

class PaystackService
{
    public function isAvailable()
    {
        return config('config.gateways.paystack.status') === 'active';
          //availability will be if there is downtime form paystack.
            //this will be done through connecting to paystack  ApI


            //DUE TO time and availability of keys to test normall for the api , i decided to fix this up from the env file down to the config.
    }

    public function getName()
    {
        return 'Paystack';
    }
    public function checkBalance()
    {
         // Implement logic to check paystack's balance.

        // this logic will be from paystack api to check for balance for the organization and it will return the balance amount.
        //Note:: The amount must tally with what is on the dashboard while accessing through paystack dashboard.
        return 10000;
    }

    public function supportsCurrency($currency)
    {
        // Example: Paystack supports NGN, USD
        return in_array($currency, ['NGN']);
    }

    public function getChargePercentage()
    {
        return 3.5;
         // Note: charges are meant to come from thr api calls too 
    }

    public function pay(array $data)
    {
      
        return new PaymentResponse(
            'Paystack',
            config('config.gateways.paystack.api_url'),
            config('config.gateways.paystack.api_key'),
            $data['total_amount'],
            $data['charge'],
            true,
            'Payment successful via Paystack.'
        );
    }
}
