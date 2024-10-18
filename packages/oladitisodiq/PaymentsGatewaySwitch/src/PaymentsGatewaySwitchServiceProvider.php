<?php

namespace PaymentsGatewaySwitch;

use Illuminate\Support\ServiceProvider;
use PaymentsGatewaySwitch\Services\PaystackService;
use PaymentsGatewaySwitch\Services\FlutterwaveService;

class PaymentsGatewaySwitchServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register PaymentsGatewaySwitch 
        $this->app->singleton(PaymentsGatewaySwitch::class, function ($app) {
            return new PaymentsGatewaySwitch([
                new PaystackService(),
                new FlutterwaveService(),
            ]);
        });

        $this->app->alias(PaymentsGatewaySwitch::class, 'PaymentsGatewaySwitch');

        //  package configuration
        $this->mergeConfigFrom(__DIR__.'/config/config.php', 'config');

        
   
    }

    public function boot()
    {
        //  config file publish
        $this->publishes([
            __DIR__.'/config/config.php' => config_path('config.php'),
        ]);
    }
}
