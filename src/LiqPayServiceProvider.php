<?php

namespace DenizTezcan\LiqPay;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class LiqPayServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/liqpay.php' => config_path('liqpay.php'),
        ]);
    }

    public function register()
    {
        $this->app->bind('liqpay', function () {
            return new LiqPay();
        });
    }

    public function provides()
    {
        return ['liqpay'];
    }
}
