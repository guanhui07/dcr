<?php
declare(strict_types = 1);
/**
 * The file is part of xxx/xxx
 *
 *
 */

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
            TestMiddleware::class => TestMiddleware::class,
            AuthMiddleware::class => AuthMiddleware::class,
        ];
    }
}
