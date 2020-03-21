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

        $this->app->when('client')
            ->needs(RestClient::METHOD_PUT)
            ->give(RestClient::METHOD_PUT);

        $this->app->when('client')
            ->needs(RestClient::METHOD_DELETE)
            ->give(RestClient::METHOD_DELETE);
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
