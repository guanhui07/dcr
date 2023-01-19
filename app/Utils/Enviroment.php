<?php

namespace app\Utils;


/**
 * Class Enviroment
 * @package app\common\utils
 */
class Enviroment
{
    public static function isProd()
    {
        return Config::get('app.env') === 'prod';
    }

    public static function isRoyeeDev()
    {
        if (file_exists('/Users/yangminghui')) {
            return true;
        }
        if (request()->get('debug') == 1) {
            return true;
        }
        return false;
    }

    public static function isDev()
    {
        return Config::get('app.env') === 'dev';
    }

    public static function isLocal()
    {
        return Config::get('app.env') === 'local';
    }
}