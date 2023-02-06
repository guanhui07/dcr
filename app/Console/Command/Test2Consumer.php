<?php
declare(strict_types = 1);
/**
 * The file is part of dcr/framework
 *
 *
 */

namespace app\Console\Command;

use app\Service\Consumer\BalancePayConsumer;
use Inhere\Console\Command;
use Inhere\Console\IO\Input;
use Inhere\Console\IO\Output;

/**
 * 测试使用 rabbitmq 消费者
 * php artisan test2_consumer
 */
class Test2Consumer extends Command
{
    protected static string $name = 'test2_consumer';

    protected static string $desc = 'print system ENV information';

    protected function execute(Input $input, Output $output): void
    {
        $producer = new BalancePayConsumer();
        $producer->consumer('balance_pay');
    }
}
