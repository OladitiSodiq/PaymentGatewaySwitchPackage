<?php

namespace PaymentsGatewaySwitch\Facades;

use Illuminate\Support\Facades\Facade;

class PaymentsGatewaySwitch extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'PaymentsGatewaySwitch';
    }
}
