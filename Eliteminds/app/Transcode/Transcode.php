<?php


namespace App\Transcode;


class Transcode
{
    public static function resolveFacade($name){
        return app()[$name];
    }

    public static function __callStatic($method, $arg){
        return self::resolveFacade('Transcode')->$method(...$arg);
    }

}
