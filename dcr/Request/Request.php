<?php
declare(strict_types = 1);
/**
 * The file is part of dcr/framework
 *
 *
 */

namespace dcr\Request;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use dcr\Request as DcrRequest;

/**
 * Class Request
 * @package dcr\Request
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
