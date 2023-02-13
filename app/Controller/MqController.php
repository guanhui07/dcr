<?php declare(strict_types=1);
/**
 * The file is part of Dcr/framework
 *
 *
 */

namespace App\Controller;

use App\Utils\Mq\MqProducer;
use Dcr\Annotation\Mapping\RequestMapping;
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
    #[RequestMapping(methods: 'GET , POST', path:'/test/test_mq')]
    public function test(): bool|string
    {
        $queueParam = ['test' => 111];
        $producer   = new MqProducer();
        $producer->publish($queueParam, 'balance_pay', 1);
        return apiResponse([]);
    }
}
