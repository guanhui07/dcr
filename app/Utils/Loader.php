<?php declare(strict_types=1);
/**
 * The file is part of Dcr/framework
 *
 *
 */

namespace App\Utils;

class Loader
{
    public static function autoload($className): void
    {
        $file = str_replace('\\', '/', $className).'.php';
        if (file_exists($file)) {
            include_once $file;
        }
    }
}
