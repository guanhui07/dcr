<?php
declare(strict_types = 1);

namespace app\Middleware;

/**
 * Class Kernel
 * @package app\Middleware
 * @see @see https://github.com/middlewares/utils
 */
class Kernel
{
    public static function getMiddlewares(): array
    {
        return [
            TestMiddleware::$name => TestMiddleware::class,
            AuthMiddleware::$name => AuthMiddleware::class,
        ];
    }
}