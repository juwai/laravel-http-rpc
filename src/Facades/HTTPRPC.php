<?php
namespace Juwai\LaravelHTTPRPC\Facades;

use Illuminate\Support\Facades\Facade;

class HTTPRPC extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'HTTPRPC';
    }
}
