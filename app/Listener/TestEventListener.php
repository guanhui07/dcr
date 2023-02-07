<?php
declare(strict_types = 1);

namespace app\Listener;

use app\Event\TestEvent;
use app\Utils\LogBase;
use Symfony\Contracts\EventDispatcher\Event;

class TestEventListener implements BaseListenerInterface
{
    /**
     * @param  TestEvent  $event
     */
    public function process(object $event)
    {
        echo '打印参数'.PHP_EOL;
        var_dump($event->getParams());
    }
}