<?php

namespace PaymentsGatewaySwitch\Response;

class PaymentResponse
{
    public $provider;
    public $apiUrl;
    public $apiKey;
    public $status;
    public $message;

    public function __construct($provider, $apiUrl, $apiKey, $status, $message)
    {
        $this->provider = $provider;
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
        $this->status = $status;
        $this->message = $message;
    }

    public function toArray()
    {
        return [
            'provider' => $this->provider,
            'api_url' => $this->apiUrl,
            'api_key' => $this->apiKey,
            'status' => $this->status,
            'message' => $this->message,
        ];

        
    }
}
