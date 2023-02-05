<?php
declare(strict_types=1);
/**
 * The file is part of xxx/xxx
 *
 *
 */

namespace app\Utils;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Log
{
    public function info($str): void
    {
        $log = $this->getLogger(Logger::INFO);
        $log->warning((string)$str);
    }

    public function debug($str): void
    {
        $log = $this->getLogger(Logger::INFO);
        $log->warning((string)$str);
    }

    public function warning($str): void
    {
        $log = $this->getLogger(Logger::WARNING);
        $log->warning((string)$str);
    }

    public function error($str): void
    {
        $log = $this->getLogger(Logger::ERROR);
        // add records to the log
        $log->error((string)$str);
    }

    public function write($str, $config = ''): void
    {
        $this->error($str);
    }

    /**
     * @param int $level
     * @return Logger
     */
    protected function getLogger($level = Logger::WARNING): Logger
    {
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler(PROJECT_ROOT . 'runtime/log.log', $level));
        return $log;
    }
}
