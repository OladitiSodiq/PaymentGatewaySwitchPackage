<?php
namespace PaymentsGatewaySwitch;

use PaymentsGatewaySwitch\Response\PaymentResponse;
use Exception;

class PaymentsGatewaySwitch
{
    protected $gateways;
    protected $currencyMapping;

    public function __construct(array $gateways)
    {
        $this->gateways = $gateways;
        $this->currencyMapping = config('config.location_currency_mapping');
    }

    protected function getCurrencyForLocation($location)
    {
        // dd( $this->currencyMapping[$location]);
        return $this->currencyMapping[$location] ?? config('config.default_currency');
    }

    protected function switchPaymentGateway(array $data)
    {
        $currency = $this->getCurrencyForLocation($data['location']);

        // dd($currency);

        foreach ($this->gateways as $gateway) {
            if ($gateway->isAvailable() && $gateway->checkBalance() >= $data['amount'] && $gateway->supportsCurrency($currency)) {
                return $gateway->pay($data);
            }
        }

        throw new Exception('No suitable payment gateway available.');
    }

    public function pay(array $data)
    {
        return $this->switchPaymentGateway($data);
    }
}
