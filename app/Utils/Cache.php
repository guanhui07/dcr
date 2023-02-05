<?php
declare(strict_types = 1);
/**
 * The file is part of xxx/xxx
 *
 *
 */

namespace app\Utils;

class Cache
{
    public static function set($key, $value, $ttl = null)
    {
        return Redis::connection()->setex($key, $ttl, serialize($value));
    }

    public static function get($key, $default = null)
    {
        $val = Redis::connection()->get($key);
        if ($val) {
            return unserialize($val);
        }
        return $default;
    }

    public static function delete($key)
    {
        return Redis::connection()->del($key);
    }
}
