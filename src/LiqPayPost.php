<?php

namespace DenizTezcan\LiqPay;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';

use GuzzleHttp\Client as Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use DenizTezcan\LiqPay\Support\LiqPay as AbstractLiqPay;

// include('../config/liqpay.php');
class LiqPayPost
{
    public function __construct(
        float $amount = 1.00,
        string $currency = 'UAH',
        string $description = 'foo',
        string $order_id = "bar",
        string $result_url = "https://www.liqpay.ua/ru/checkout/card/",
        string $server_url = "",
        string $public_key = "",
        string $private_key = "",
        ) 
    { 
        $this->amount = $amount;
        $this->currency = $currency;
        $this->description = $description;
        $this->order_id = $order_id;
        $this->result_url = $result_url.$public_key;
        $this->server_url = $server_url;
        $this->public_key = $public_key;
        $this->private_key = $private_key;
    }

    public function pay(
        float $amount = 1.00,
        string $currency = 'USD',
        string $description = 'foo',
        string $order_id = "bar",
        string $result_url = "https://www.liqpay.ua/ru/checkout/card/",
        string $server_url = "",
        string $public_key = "",
        string $private_key = "",
    ): void 
    {
        $client = new Client([
            'base_uri' => 'http://localhost:8000/', 
            'form_params' => [
                'action' => 'pay',
                'amount' => $amount,
                'currency' => $currency,
                'description' => $description,
                'order_id' => $order_id,
                'version' => '3',
                'result_url' => $result_url,
                'server_url' => $server_url,
            ],
            'language' => 'en',

        ]);

        $request = $client->post('https://www.liqpay.ua/api/3/checkout', [
            'form_params' => [
                'action' => 'pay',
                'amount' => $amount,
                'currency' => $currency,
                'description' => $description,
                'order_id' => $order_id,
                'version' => '3',
                'result_url' => $result_url,
                'server_url' => $server_url,
            ],
            'language' => 'en',
        ]);

        $data = $this->formData(
            [
                'form_params' => [
                    'action' => 'pay',
                    'amount' => $amount,
                    'currency' => $currency,
                    'description' => $description,
                    'order_id' => $order_id,
                    'version' => '3',
                    'result_url' => $result_url,
                    'server_url' => $server_url,
                ],
            ],
        ); 

        $liqPayClient = new AbstractLiqPay($result_url, null, $data, $public_key, $private_key);
        header('Location:'.$liqPayClient->_api_url);
    }

    public function formData(array $params): string
    {
        $language = 'ru';
        if (isset($params['language']) && $params['language'] === 'en') {
            $language = 'en';
        }

        $params    = $this->validateParams($params); 
        $data      = $this->dataToString($params); 

        return $data;
    }

    public function validateParams(array $params): array
    {
        $suppotedCurrencyArray = [
            'EUR',
            'USD',
            'UAH',
            'RUB',
            'RUR',
        ];
        
        ($params['form_params']['version'] !== null) ?? die('version is null');
        ($params['form_params']['amount'] !== null) ?? die('payment amount not specified');
        (($params['form_params']['currency'] !== null) && in_array($params['form_params']['currency'], $suppotedCurrencyArray)) ?? die('unsupported currency');
        ($params['form_params']['currency'] === 'RUR') ?? $params['form_params']['currency'] = 'RUB';
        ($params['form_params']['description'] !== null) ?? die('description is empty');
        ($params['form_params']['result_url'] !== null) ?? die('result_url not specified');
        ($params['form_params']['server_url'] !== null) ?? die('server_url not specified');
        ($params['form_params']['order_id'] !== null) ?? die('order_id not specified');

        return $params;
    }

    public function dataToString(array $params): string
    {
        return base64_encode(json_encode($params));
    }


    public function status(string $order_id = "bar"): string|false
    {
        $data = $this->client->api("request", array(
            'action' => 'status',
            'version' => '3',
            'order_id' => $order_id
        ));

        return json_encode($data, TRUE);
    }
}
$pay = new LiqPayPost();
$pay->pay();