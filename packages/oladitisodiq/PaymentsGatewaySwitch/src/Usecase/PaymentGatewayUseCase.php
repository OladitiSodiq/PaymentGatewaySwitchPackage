<?php
namespace PaymentsGatewaySwitch\UseCase;

interface PaymentGatewayUseCase
{
    public function isAvailable(): bool;

    public function checkBalance(): float;

    public function pay(array $data);

    public function supportsCurrency(string $currency, ?string $location): bool;
}
