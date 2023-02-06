<?php
declare(strict_types = 1);
/**
 * The file is part of dcr/framework
 *
 *
 */

namespace app\Utils;

use Predis\Client;

/**
 * Class Redis
 * @see https://github.com/predis/predis
 */
class Redis
{
    public static function connection(): Client
    {
        return new Client('tcp://127.0.0.1:6379');
    }
}
