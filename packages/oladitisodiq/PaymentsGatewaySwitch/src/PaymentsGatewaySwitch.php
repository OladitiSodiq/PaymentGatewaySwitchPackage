<?php
namespace PaymentsGatewaySwitch;


// use Exception;
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

    protected function switchPaymentGateway(array $data)
    {
        $currency = $this->getCurrencyForLocation($data['location']);
        $amount = $data['amount'];
        $suitableGateways = [];

        // help Collect all suitable gateways for the payment attempt.
        foreach ($this->gateways as $gateway) {
            if (!$gateway->isAvailable()) {
                Log::info("Gateway {$gateway->getName()} is not available. Skipping to the next.");
                continue;
            }

            if (!$gateway->supportsCurrency($currency)) {
                Log::info("Gateway {$gateway->getName()} does not support the currency: $currency. Skipping to the next.");
                continue;
            }

            if ($gateway->checkBalance() < $amount) {
                Log::info("Gateway {$gateway->getName()} does not have sufficient balance for the amount: $amount. Skipping to the next.");
                continue;
            }

            // Add to the list of suitable gateways for potential fallback.
            $suitableGateways[] = $gateway;
        }

      
        foreach ($suitableGateways as $gateway) {
            try {
                Log::info("Attempting payment with {$gateway->getName()}.");
                return $gateway->pay($data);
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
