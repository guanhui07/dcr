<?php
declare(strict_types = 1);
/**
 * The file is part of xxx/xxx
 *
 *
 */

namespace app\Provider;

use app\Event\TestEvent;
use app\Listener\TestEventListener;

/**
 * 事件
 * @see  https://www.doctrine-project.org/projects/doctrine-event-manager/en/latest/reference/index.html#setup
 */
class EventServiceProvider
{
    /**
     * @return string[]
     */
    public static function getEventConfig()
    {
        return [
            // 事件 绑定 监听
            TestEvent::class => TestEventListener::class,

        ];
    }
}
