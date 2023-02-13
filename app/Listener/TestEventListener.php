<?php
declare(strict_types = 1);

namespace App\Listener;

use App\Event\TestEvent;
use App\Utils\LogBase;
use Symfony\Contracts\EventDispatcher\Event;

class TestEventListener implements BaseListenerInterface
{
    /**
     * @param  TestEvent  $event
     */
    public function process(object $event)
    {
        echo '测试event:打印参数'.PHP_EOL;
        var_dump($event->getParams());
    }
}