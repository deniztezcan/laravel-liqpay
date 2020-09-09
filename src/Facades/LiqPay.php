<?php

namespace DenizTezcan\LiqPay\Facades;

use Illuminate\Support\Facades\Facade;

class LiqPay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'liqpay';
    }
}
