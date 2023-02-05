<?php declare(strict_types=1);
/**
 * The file is part of xxx/xxx
 *
 *
 */

namespace app\Controller;

use app\Utils\Mq\MqProducer;
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

    /**
     * 测试使用 rabbitmq 生产者
     * @return bool|string
     * @throws Exception
     */
    #[RequestMapping(methods: 'GET , POST', path:'/')]
    public function test1()
    {
        return apiResponse('hello world');
    }
}
