<?php
declare(strict_types = 1);
/**
 * The file is part of Dcr/framework
 *
 *
 */

namespace Dcr\Response;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class Response
 * @package Dcr\Response
 * @see https://symfony.com/doc/current/components/http_foundation.html#response
 */
class Response
{
    /**
     * @var SymfonyResponse
     */
    public static $ins;

    public static function instance(): SymfonyResponse
    {
        if (!self::$ins) {
            $ins       = new SymfonyResponse;
            self::$ins = $ins;
            return self::$ins;
        }

        return self::$ins;
    }

    /**
     * @param  string  $str
     *
     * @return SymfonyResponse
     */
    public function send(string $str): SymfonyResponse
    {
        $response = self::instance();
        $response->setContent($str);
        return $response->send();
    }
}
