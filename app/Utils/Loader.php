<?php declare(strict_types=1);
/**
 * The file is part of xxx/xxx
 *
 *
 */

namespace app\Utils;

class Loader
{
    public static function autoload($className): void
    {
        $file = str_replace('\\', '/', $className).'.php';
        if (file_exists($file)) {
            include_once $file;
        } else {
            //todo日志
        }
    }
}
