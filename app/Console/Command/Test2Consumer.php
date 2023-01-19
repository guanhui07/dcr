<?php
declare(strict_types = 1);

namespace app\Console\Command;

use app\Service\Consumer\BalancePayConsumer;
use Inhere\Console\IO\Input;
use Inhere\Console\IO\Output;


/**
 * 测试使用 rabbitmq 消费者
 * Class Test2Consumer
 * @package app\Console\Command
 * php artisan test2_consumer
 */
class Test2Consumer extends \Inhere\Console\Command
{
    protected static string $name = 'test2_consumer';

    protected static string $desc = 'print system ENV information';

    protected function execute(Input $input, Output $output)
    {
        $producer = new BalancePayConsumer();
        $producer->consumer('test_pay');
    }
}



