<?php
declare(strict_types = 1);
/**
 * The file is part of xxx/xxx
 *
 *
 */

namespace app\Middleware;

use app\Exception\RuntimeException;
use app\Middleware\Contract\MiddlewareInterface;

class TestMiddleware implements MiddlewareInterface
{
    public static string $name = 'test1';

    public function handle(): \Closure
    {
        return static function ($request, $next) {
//            throw new RuntimeException('未登录');
            return $next->handle($request);
        };
    }

    //    public function handle($request, $next)
    //    {
    //            //            echo 'from middleware';
    //            $response = $next->handle($request);
    //            return $response;
    //    }
}
