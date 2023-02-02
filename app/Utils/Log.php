<?php
declare(strict_types = 1);

namespace app\Utils;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class Log
 * @package app\Utils
 * @see https://github.com/Seldaek/monolog
 */
class Log
{
    public static function info($str)
    {
        $log = self::getLogger(Logger::INFO);
        $log->warning((string)$str);
    }

    public static function warning($str)
    {
        $log = self::getLogger(Logger::WARNING);
        $log->warning((string)$str);
    }

    public static function error($str)
    {
        $log = self::getLogger(Logger::ERROR);
        // add records to the log
        $log->error((string)$str);
    }

    public static function write($str,$config='')
    {
        self::error($str);
    }

    /**
     * @param  int  $level
     *
     * @return Logger
     */
    protected static function getLogger($level = Logger::WARNING): Logger
    {
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler(PROJECT_ROOT.'runtime/log.log', $level));
        return $log;
    }
}