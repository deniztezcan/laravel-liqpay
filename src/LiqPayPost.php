<?php

namespace DenizTezcan\LiqPay;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



require '../vendor/autoload.php';


// dd('trololo');

use GuzzleHttp\Client as Client;
use GuzzleHttp\Psr7\Request;
use DenizTezcan\LiqPay\Support\LiqPay as AbstractLiqPay;

class LiqPayPost
{
    public function __construct(
        // protected ...$client = null,
    )
    {
        // $this->client = new AbstractLiqPay('sandbox_i35444360364', 'sandbox_oes9JoLcbl3oCgpafe8xfQW5sHpifiR34KDKWHhF');
    }

    public function pay(
        float $amount = 1.00,
        string $currency = 'UAH',
        string $description = 'foo',
        string $order_id = "bar",
        string $result_url = "",
        string $server_url = "",
    ): void {
        

        $client = new Client([
            'base_uri' => 'http://localhost:8000/',//$_checkout_url = 'https://www.liqpay.ua/api/3/checkout',
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
        ]);

        //зачем ты вместо урла указала путь к файлу ? чтобы загрузилась формма..  я не это зне нтаак ю, что указывать покажу в доку
        $response = $client->request('POST', 'https://www.liqpay.ua/api/3/checkout', [
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
        ]);
        $data = json_encode($response->getBody());
        dd($data);

        $liqPayClient = new AbstractLiqPay('https://www.liqpay.ua/api/3/checkout', null, $data['form_params'],'sandbox_i35444360364', 'sandbox_oes9JoLcbl3oCgpafe8xfQW5sHpifiR34KDKWHhF');
        $form = file_get_contents('form/index.html');

        $data = $response->form_params;
        dd($data);
        // $data = '123';
        $script = '<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script><script type="text/javascript">jQuery(document).ready(function($) {$("form").submit();});</script> ';
        $html = $form.$script;
        // return $html;
        // var_dump($html);
        // return $data;
        // return $data;
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
