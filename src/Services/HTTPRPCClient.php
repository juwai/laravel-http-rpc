<?php
namespace Juwai\LaravelHTTPRPC\Services;

use GuzzleHttp\Client;

class HTTPRPCClient extends Client
{
    public function __construct($options)
    {
        parent::__construct($options);
    }

    public function __call($name, $args)
    {
        $queryString = $name . '/';
        foreach ($args as $arg) {
            $arg = urlencode(json_encode($arg));
            $queryString .= $arg . '/';
        }

        if (self::debugbarEnabled()) {
            $uid = uniqid();
            start_measure($uid, 'RPC: ' . $name);
            debug('RPC: ' . $name . ' ' . json_encode($args));
            $response = $this->request('GET', $queryString);
            stop_measure($uid);
        } else {
            $response = $this->request('GET', $queryString);
        }

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Check if Debugbar is enabled
     *
     * @return bool
     */
    public static function debugbarEnabled()
    {
        return app()->bound('Barryvdh\Debugbar\LaravelDebugbar');
    }
}
