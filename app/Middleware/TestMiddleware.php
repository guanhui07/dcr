<?php
declare(strict_types = 1);

namespace app\Middleware;

use app\Middleware\Contract\MiddlewareInterface;

class TestMiddleware implements MiddlewareInterface
{
    public static string $name = 'test1';

    public function handle()
    {
        return static function ($request, $next) {
            //            echo 'from middleware';return;
            $response = $next->handle($request);
            return $response;
        };
    }

    //    public function handle($request, $next)
    //    {
    //            //            echo 'from middleware';
    //            $response = $next->handle($request);
    //            return $response;
    //    }
}