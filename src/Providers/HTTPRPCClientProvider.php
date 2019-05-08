<?php
namespace Juwai\LaravelHTTPRPC\Providers;

use Illuminate\Support\ServiceProvider;

use Juwai\LaravelHTTPRPC\Services\HTTPRPCFactory;

class HTTPRPCClientProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/httprpc.php' => base_path('config/httprpc.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('HTTPRPC', function ($app) {
            return new HTTPRPCFactory();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['HTTPRPC'];
    }
}
