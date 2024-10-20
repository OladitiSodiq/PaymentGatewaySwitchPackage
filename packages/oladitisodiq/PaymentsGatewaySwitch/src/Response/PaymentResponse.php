<?php

namespace PaymentsGatewaySwitch\Response;

class PaymentResponse
{
    public $provider;
    public $apiUrl;
    public $apiKey;
    public $status;
    public $message;

    public $amount;

    public $charges;

    public function __construct($provider, $apiUrl, $apiKey,$amount,$charges, $status, $message)
    {
        $this->provider = $provider;
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
        $this->amount = $amount;
        $this->charges = $charges;
        $this->status = $status;
        $this->message = $message;
    }

    public function toArray()
    {
        return [
            'provider' => $this->provider,
            'api_url' => $this->apiUrl,
            'api_key' => $this->apiKey,
            'total_amount' =>  $this->amount,
            'charges' =>  $this->charges,
            'status' => $this->status,
            'message' => $this->message,
        ];

        
    }
}
