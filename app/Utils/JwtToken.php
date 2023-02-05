<?php declare(strict_types=1);
/**
 * The file is part of xxx/xxx
 *
 *
 */

namespace app\Utils;

use app\Traits\BaseRequest;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtToken
{
    use BaseRequest;

    public const JWT_SEC_KEY = 'ranndom_Key_$888';

    public static float|int $expire_token_time = 60 * 60; //min

    public static function getTokenOriTime()
    {
        return self::$expire_token_time;
    }

    /**
     * @param $data
     *
     * @return string
     */
    public static function encode(array $data): string
    {
        $key = self::JWT_SEC_KEY;
        //JWT::$leeway = 60; //seconds
        $jwt_token = JWT::encode($data, $key, 'HS256');

        $jwt_token_cache_key = md5($jwt_token.time().str_random(10));
        $data['jwt_token']   = $jwt_token;

        Cache::set($jwt_token_cache_key, $data, self::$expire_token_time);
        return $jwt_token_cache_key;
    }

    /**
     * @param $token
     *
     * @return array
     */
    public static function decode(string $token): array
    {
        $key          = self::JWT_SEC_KEY;
        $cache_exists = Cache::get($token);

        if (!$cache_exists) {
            return [];
        }
        $token = $cache_exists['jwt_token'];

        try {
            $decoded = (array) JWT::decode($token, new Key($key, 'HS256'));
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }

        return $decoded;
    }

    public static function refresh(string $token)
    {
        $key          = self::JWT_SEC_KEY;
        $new_token    = '';
        $cache_exists = Cache::get($token);

        if (!$cache_exists) {
            return false;
        }
        $token = $cache_exists['jwt_token'];

        try {
            $decoded = (array) JWT::decode($token, new Key($key, 'HS256'));
        } catch (Exception $e) {
            return false;
        }
        if ($decoded) {
            $new_token = self::encode($decoded);
        }
        return $new_token;
    }

    //存活时间
    public static function ttlToken(string $token)
    {
        $prefix = config('cache.prefix').':';
        $ret    = Redis::connection()->ttl($prefix.$token);
        if ($ret == -2) {
            $ret = 0;
        }
        return $ret; //ttl 秒
    }

    //延长时间
    public static function expireToken(string $token, $ttl = 600)
    {
        $prefix = config('cache.prefix').':';
        return Redis::connection()->expire($prefix.$token, $ttl);
    }

    public static function delete($token): bool
    {
        return Cache::delete($token);
    }

    //test
    public function test()
    {
        $key   = self::JWT_SEC_KEY;
        $token = [
            'iss1' => 'http://test.org', 'aud1' => 'test11',
            'iat1' => 1356999524,
            'nbf1' => 1357000000,
        ];

        $jwt = JWT::encode($token, $key, 'HS256');

        try {
            $decoded = (array) JWT::decode($jwt, new Key($key, 'HS256'));
        } catch (Exception $e) {
            return false;
        }
        print_r($decoded);
        die;
    }
}
