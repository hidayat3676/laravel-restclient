<?php


namespace hidayat\restclient\client\Facade;
use \Illuminate\Support\Facades\Facade;

class Client extends Facade
{

    protected static function getFacadeAccessor(){

        return 'client';

    }

}
