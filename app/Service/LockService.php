<?php

declare(strict_types = 1);
/**
 * The file is part of xxx/xxx
 *
 *
 */

namespace app\Service;

use app\Utils\Redis;
use Exception;
use RuntimeException;

/**
 * Class LockService
 * @package app\Service
 */
class LockService
{
    public function run(string $key, callable $callback, int $ttl = 3): void
    {
        $flag = $this->lock($key, $ttl);
        if (!$flag) {
            throw new RuntimeException('未获取到锁');
        }
        try {
            $callback();
        } catch (Exception $e) {
            throw $e;
        } finally {
            $this->unlock($key);
        }
    }

    /**
     * @param  string  $key
     * @param  int  $expire
     *
     * @return \Predis\Response\Status
     */
    public function lock(string $key, int $expire = 3): \Predis\Response\Status
    {
        $handler = Redis::connection();
        return $handler->set($key, 1, ['NX', 'EX' => $expire]);
    }

    /**
     * @param  string  $key
     *
     * @return int
     */
    public function unlock(string $key): int
    {
        $handler = Redis::connection();
        return $handler->del($key);
    }
}
