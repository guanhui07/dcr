<?php

declare(strict_types = 1);

namespace app\Service;

use app\Utils\Json;
use app\Utils\Redis;

/**
 * @package app\Service
 */
class RedisQueueService
{
    public static function push(string $key, $data = [])
    {
        $handler = Redis::connection();
        if (is_array($data)) {
            $data = Json::encode($data);
        }
        return $handler->lPush($key, $data);
    }

    public static function pop(string $key, int $ttl = 10): array
    {
        $handler = Redis::connection();
        $data    = $handler->brPop($key, $ttl);
        if (empty($data)) {
            return [];
        }
        return Json::decode($data[1], true);
    }

}