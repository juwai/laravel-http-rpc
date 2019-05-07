# laravel-http-rpc

This package provides an easy way of connecting to HTTP RPC.

## Installation

1. Add facade and providers to `config/app.php`

    ```php
    'aliases' => [
        ...
        'HTTPRPC' => Juwai\LaravelHTTPRPC\Facades\HTTPRPC::class,
    ],
    ```

    ```php
    'providers' => [
        ...
        Juwai\LaravelHTTPRPC\Providers\HTTPRPCClientProvider::class,
    ],
    ```

1. Publish config file:

    ```bash
    $ php artisan vendor:publish
    ```

1. Add real service configuration to the published config file
`config/httprpc.php`.

## Usage

### GET method
```php
$client = HTTPRPC::get('service_one', '1.0');
$response = $client->service_function($param1, $param2);
```

### POST method
```php
$client = HTTPRPC::get('service_one', '1.0', 2000, 'POST');
$response = $client->service_function(['param1' => $param1, 'param2' => $param2]);
```

## Connection monitor

If you installed [Debugbar](https://github.com/barryvdh/laravel-debugbar) the RPC connection information shows on Debugbar panels.
