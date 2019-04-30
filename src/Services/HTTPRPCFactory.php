<?php
namespace Juwai\LaravelHTTPRPC\Services;

class HTTPRPCFactory
{
    private static $_clients = [];

    public function get($serviceName, $version, $timeout = null)
    {
        $key = $serviceName . $version . $timeout;
        if (array_key_exists($key, self::$_clients)) {
            return self::$_clients[$key];
        }
        if ($timeout == null) {
            $timeout = env('DEFAULT_RPC_TIMEOUT', 1000);
        }
        $options = [
            'base_uri' => config('httprpc.HTTP_RPC_' . strtoupper($serviceName))[$version] . '/',
            'timeout' => $timeout
        ];
        $client = new HTTPRPCClient($options);
        self::$_clients[$key] = $client;

        return $client;
    }

    public function destroyClient($serviceName, $version, $timeout = null)
    {
        $key = $serviceName . $version . $timeout;
        unset(self::$_clients[$key]);
    }
}
