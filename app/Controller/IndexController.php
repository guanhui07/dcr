<?php declare(strict_types=1);
/**
 * The file is part of dcr/framework
 *
 *
 */

namespace app\Controller;

use app\Middleware\AuthMiddleware;
use app\Middleware\TestMiddleware;
use app\Utils\Mq\MqProducer;
use dcr\Annotation\Mapping\Middlewares;
use dcr\Annotation\Mapping\RequestMapping;
use Exception;

class IndexController extends Controller
{
    /**
     * MqController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    #[RequestMapping(methods: "GET , POST", path:"/index/test1")]
    public function test(): string
    {
        return 'hello world';
    }


    /**
     * 测试路由注解
     * 测试中间件注解
     * @return string
     */
    #[RequestMapping(methods: "GET , POST", path:"/index/test2")]
    #[Middlewares(AuthMiddleware::class, TestMiddleware::class)]
    public function test2(): string
    {
        return 'test 1121';
    }
}
