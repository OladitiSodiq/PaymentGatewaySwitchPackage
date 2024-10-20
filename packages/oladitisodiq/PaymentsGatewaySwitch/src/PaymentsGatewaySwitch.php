<?php

namespace PaymentsGatewaySwitch;

use Illuminate\Support\Facades\Log;
use PaymentsGatewaySwitch\Response\PaymentResponse;

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

    protected function calculateTotalWithCharges($amount, $chargePercentage)
    {
        return $amount + ($amount * $chargePercentage / 100);
    }

    protected function switchPaymentGateway(array $data)
    {
        // dd($data);
        $currency = $this->getCurrencyForLocation($data['location']);
        $amount = $data['amount'];
        $suitableGateways = [];

        // Collect all suitable gateways for the payment attempt.
        foreach ($this->gateways as $gateway) {
            if (!$gateway->isAvailable()) {
                Log::info("Gateway {$gateway->getName()} is not available. Skipping to the next.");
                continue;
            }

            if (!$gateway->supportsCurrency($currency)) {
                Log::info("Gateway {$gateway->getName()} does not support the currency: $currency. Skipping to the next.");
                continue;
            }

            // Calculate the total amount including the charges for this gateway.
            $chargePercentage = $gateway->getChargePercentage();
            $totalAmount = $this->calculateTotalWithCharges($amount, $chargePercentage);

            // dd( $amount);

            if ($gateway->checkBalance() < $totalAmount) {
                Log::info("Gateway {$gateway->getName()} does not have sufficient balance for the total amount: $totalAmount. Skipping to the next.");
                continue;
            }

            // Add to the list of suitable gateways for potential fallback.
            $suitableGateways[] = [
                'gateway' => $gateway,
                'total_amount' => $totalAmount,
                'charge' => $chargePercentage,
            ];
        }

        
        foreach ($suitableGateways as $gatewayData) {
            $gateway = $gatewayData['gateway'];
            $totalAmount = $gatewayData['total_amount'];

            try {
                Log::info("Attempting payment with {$gateway->getName()} with a total amount of {$totalAmount} including charges.");
                return $gateway->pay(array_merge($data, ['total_amount' => $totalAmount, 'charge' => $gatewayData['charge']]));
            } catch (\Exception $e) {
                 // Log the failure and try the next suitable gateway.
                Log::error("Payment through {$gateway->getName()} failed: " . $e->getMessage());
            }
        }

        // If no gateways are able to process the payment, throw an exception.
        throw new \Exception('No suitable payment gateway available.');
    }

    public function pay(array $data)
    {
        return $this->switchPaymentGateway($data);
    }
}