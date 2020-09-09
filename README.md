# Laravel LiqPay
[![Latest Stable Version](https://poser.pugx.org/deniztezcan/laravel-liqpay/v/stable)](https://packagist.org/packages/deniztezcan/laravel-liqpay) 
[![Total Downloads](https://poser.pugx.org/deniztezcan/laravel-liqpay/downloads)](https://packagist.org/packages/deniztezcan/laravel-liqpay) 
[![Latest Unstable Version](https://poser.pugx.org/deniztezcan/laravel-liqpay/v/unstable)](https://packagist.org/packages/deniztezcan/laravel-liqpay) 
[![License](https://poser.pugx.org/deniztezcan/laravel-liqpay/license)](https://packagist.org/packages/deniztezcan/laravel-liqpay)
[![Maintainability](https://api.codeclimate.com/v1/badges/9057b79855fcc029f989/maintainability)](https://codeclimate.com/github/deniztezcan/laravel-liqpay/maintainability)

A Laravel package for the LiqPay PHP SDK.

## Instalation
```
composer require deniztezcan/laravel-liqpay
```

Add a ServiceProvider to your providers array in `config/app.php`:
```php
    'providers' => [
    	//other things here

    	DenizTezcan\LiqPay\LiqPayServiceProvider::class,
    ];
```

Add the facade to the facades array:
```php
    'aliases' => [
    	//other things here

    	'LiqPay' => DenizTezcan\LiqPay\Facades\LiqPay::class,
    ];
```

Finally, publish the configuration files:
```
php artisan vendor:publish --provider="DenizTezcan\LiqPay\LiqPayServiceProvider"
```

### Configuration
Please set your API: `LIQPAY_PUBLIC` and `LIQPAY_PRIVATE` in the `.env` file 