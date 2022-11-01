<?php


namespace App\Zone;


class Zone
{
    public static function resolveFacade($name){
        return app()[$name];
    }

    public static function __callStatic($method, $arg){
        return self::resolveFacade('Zone')->$method(...$arg);
    }

}
