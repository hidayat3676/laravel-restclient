<?php


namespace hidayat\restclient\src\client\Facade;
use \Illuminate\Support\Facades\Facade;

class Client extends Facade
{

    protected static function getFacadeAccessor(){

        return 'client';

    }

}
