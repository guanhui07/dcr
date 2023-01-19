<?php
declare(strict_types = 1);

namespace app\Middleware;

use app\Middleware\Contract\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{

    public static string $name = 'auth';

    public function handle()
    {
        return static function ($request, $next) {
            //            if($isNotLogin){
            //                echo 'from middleware';return;
            //            }
            return $next->handle($request);
        };
    }

}