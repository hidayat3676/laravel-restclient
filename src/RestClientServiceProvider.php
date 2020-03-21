<?php

namespace hidayat\restclient;

use Illuminate\Support\ServiceProvider;
use hidayat\restclient\client\RestClient;
class RestClientServiceProvider extends ServiceProvider
{

    protected $defer = true;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('client', function ($app){
            return new RestClient();

        });

        $this->app->when('client')
            ->needs(RestClient::METHOD_POST)
            ->give(RestClient::METHOD_POST);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function provides()
    {
        return 'client';
    }
}
