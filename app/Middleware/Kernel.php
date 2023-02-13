<?php
declare(strict_types = 1);
/**
 * The file is part of Dcr/framework
 *
 *
 */

namespace App\Middleware;

/**
 * Class Kernel
 * @package App\Middleware
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
