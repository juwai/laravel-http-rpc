<?php
namespace Juwai\LaravelHTTPRPC\Services;

use GuzzleHttp\Client;

class HTTPRPCClient extends Client
{
    public function __construct($options)
    {
        $this->options = $options;
        parent::__construct($options);
    }

    public function __call($name, $args)
    {
        // Print RPC connection information on Debugbar
        if (self::debugbarEnabled()) {
            $uid = uniqid();
            start_measure($uid, 'RPC: ' . $name);
            debug('RPC: ' . $name . ' ' . json_encode($args));
            $result = $this->callRPC($name, $args);
            stop_measure($uid);
        } else {
            $result = $this->callRPC($name, $args);
        }

        return $result;
    }

    private function callRPC($name, $args)
    {
        $queryString = $name . '/';

        if ($this->options['method'] === 'GET') {
            // Append all the arguments to the path for GET request
            foreach ($args as $arg) {
                $arg = urlencode(json_encode($arg));
                $queryString .= $arg . '/';
            }

            $response = $this->request('GET', $queryString);

        } else {
            // Only pass the first argument as the request body
            $body = $args[0] ?? [];
            foreach ($body as $key => $value) {
                if (is_array($value)) {
                    $body[$key] = json_encode($value);
                }
            }

            $response = $this->request('POST', $queryString, [
                'form_params' => $body
            ]);
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
