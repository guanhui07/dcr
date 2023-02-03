<?php

namespace app\Controller;

use app\Utils\Mq\MqProducer;
use Exception;

class MqController extends Controller
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
    public function test1()
    {
        $queueParam = ['test' => 111];
        $producer   = new MqProducer();
        $producer->publish($queueParam, 'balance_pay', 1);
        return apiResponse([]);
    }

}