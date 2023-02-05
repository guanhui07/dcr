<?php
declare(strict_types = 1);
/**
 * The file is part of xxx/xxx
 *
 *
 */

namespace app\Utils;

use Predis\Client;

/**
 * Class Redis
 * @package app\Ext
 * @see https://github.com/predis/predis
 */
class Redis
{
    public static function connection()
    {
        return new Client('tcp://127.0.0.1:6379');
    }
}
