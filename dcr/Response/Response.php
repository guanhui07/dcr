<?php
declare(strict_types = 1);
/**
 * The file is part of dcr/framework
 *
 *
 */

namespace dcr\Response;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class Response
 * @package dcr\Response
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
