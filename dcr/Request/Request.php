<?php
declare(strict_types = 1);
/**
 * The file is part of Dcr/framework
 *
 *
 */

namespace Dcr\Request;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Dcr\Request as DcrRequest;

/**
 * Class Request
 * @package Dcr\Request
 * @see https://symfony.com/doc/current/components/http_foundation.html#request
 */
class Request
{
    /**
     */
    public static $ins;

    public static function instance()
    {
        if (!self::$ins) {
//            $ins       = SymfonyRequest::createFromGlobals();
            $ins       = new DcrRequest;
            self::$ins = $ins;
            return self::$ins;
        }

        return self::$ins;
    }
}
