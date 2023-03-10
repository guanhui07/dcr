<?php
declare(strict_types = 1);
/**
 * The file is part of Dcr/framework
 *
 *
 */

namespace App\Provider;

use App\Event\TestEvent;
use App\Listener\TestEventListener;

/**
 * 事件
 * @see  https://code.tutsplus.com/tutorials/handling-events-in-your-php-applications-using-the-symfony-eventdispatcher-component--cms-31328
 */
class EventServiceProvider
{
    /**
     * @return array
     */
    public static function getEventConfig()
    {
        return [
            // 事件 绑定 监听
            TestEvent::class => TestEventListener::class,

        ];
    }
}
