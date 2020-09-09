<?php

namespace DenizTezcan\LiqPay;

use DenizTezcan\LiqPay\Support\LiqPay as AbstractLiqPay;

class LiqPay
{
    protected $client = null;

    public function __construct()
    {
    	$this->client = new AbstractLiqPay(config('liqpay.public_key'), config('liqpay.private_key'));
    }

    public function pay(
    	$amount 		= 1.00,
    	$currency 		= 'UAH',
    	$description 	= 'foo',
    	$order_id 		= "bar"
    ) {
    	$this->client->cnb_form(array(
		'action'         => 'pay',
		'amount'         => $amount,
		'currency'       => $currency,
		'description'    => $description,
		'order_id'       => $order_id,
		'version'        => '3'
		));
    }

}