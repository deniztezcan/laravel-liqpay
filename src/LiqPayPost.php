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

    public function __construct()
    {
        // $this->client = new AbstractLiqPay('sandbox_i35444360364', 'sandbox_oes9JoLcbl3oCgpafe8xfQW5sHpifiR34KDKWHhF');
    }

    public function pay(
        float $amount = 1.00,
        string $currency = 'UAH',
        string $description = 'foo',
        string $order_id = "bar",
        string $result_url = "https://www.liqpay.ua/ru/checkout/card/sandbox_i35444360364",
        string $server_url = "",
        string $public_key = "",
        string $private_key = "",
    ): string {
        $client = new Client([
            'base_uri' => 'http://localhost:8000/', //$_checkout_url = 'https://www.liqpay.ua/api/3/checkout',
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

        // send data with post method to the result url 
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
        ); // answer from url


        // $liqPayClient = new AbstractLiqPay('https://www.liqpay.ua/api/3/checkout', null, $data, $public_key, $private_key);
        $form = file_get_contents('form/index.html');

        // dd($liqPayClient);
        $script = '<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script><script type="text/javascript">jQuery(document).ready(function($) {$("form").submit();});</script> ';
        
        $form = file_get_contents('form/index.html');$html = $form . $script;
        return $html;
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

    public function formData(array $params): string
    {
        $language = 'ru';
        if (isset($params['language']) && $params['language'] === 'en') {
            $language = 'en';
        }

        $params    = $this->validateParams($params); //if all params exists
        $data      = $this->getData($params); // make string from array && UTF-8
        // $signature = $this->createSignature($params); I think we don't need it
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

        // ($params['version'] !== null) ?? throw new InvalidArgumentException('version is null');
        // ($params['amount'] !== null) ?? throw new InvalidArgumentException('payment amount not specified');
        // (($params['currency'] !== null) && in_array($params['currency'], $suppotedCurrencyArray)) ?? throw new InvalidArgumentException('unsupported currency');
        // ($params['currency'] === 'RUR') ?? $params['currency'] = 'RUB';
        // ($params['description'] !== null) ?? throw new InvalidArgumentException('description is empty');
        // ($params['result_url'] !== null) ?? throw new InvalidArgumentException('result_url not specified');
        // ($params['server_url'] !== null) ?? throw new InvalidArgumentException('server_url not specified');
        // ($params['order_id'] !== null) ?? throw new InvalidArgumentException('order_id not specified');

        ($params['version'] !== null) ?? die('version is null');
        ($params['amount'] !== null) ?? die('payment amount not specified');
        (($params['currency'] !== null) && in_array($params['currency'], $suppotedCurrencyArray)) ?? die('unsupported currency');
        ($params['currency'] === 'RUR') ?? $params['currency'] = 'RUB';
        ($params['description'] !== null) ?? die('description is empty');
        ($params['result_url'] !== null) ?? die('result_url not specified');
        ($params['server_url'] !== null) ?? die('server_url not specified');
        ($params['order_id'] !== null) ?? die('order_id not specified');

        return $params;
    }

    function checkInput($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    public function getData(array $params): string
    {
        return base64_encode(json_encode($params));
    }

    // public function createSignature(array $params): array
    // {
    //     $params      = $this->validateParams($params);
    //     $private_key = $this->_private_key;

    //     $json      = $this->encode_params($params);
    //     $signature = $this->str_to_sign($private_key . $json . $private_key);

    //     base64_encode(sha1($str, 1))

    //     return $signature;
    // }
}
$pay = new LiqPayPost();
$pay->pay();
