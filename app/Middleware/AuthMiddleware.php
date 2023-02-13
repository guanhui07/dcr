<?php
declare(strict_types = 1);
/**
 * The file is part of Dcr/framework
 *
 *
 */

namespace App\Middleware;

use App\Exception\RuntimeException;
use App\Middleware\Contract\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public static string $name = 'auth';

    public function handle(): \Closure
    {
        return static function ($request, $next) {
            //            if($isNotLogin){
            //  throw new RuntimeException('auth error');
            //            }
            return $next->handle($request);
        };
    }
}
