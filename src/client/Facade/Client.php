<?php


namespace hidayat\restclient\Facade;
use \Illuminate\Support\Facades\Facade;

class Client extends Facade
{

    protected static function getFacadeAccessor(){

        return 'client';

    }

}
