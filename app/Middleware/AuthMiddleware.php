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

class AuthMiddleware implements MiddlewareInterface
{
    public static string $name = 'auth';

    public function handle()
    {
        return static function ($request, $next) {
            //            if($isNotLogin){
            //  throw new RuntimeException('auth error');
            //            }
            return $next->handle($request);
        };
    }
}
