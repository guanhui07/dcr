<?php
declare(strict_types = 1);
/**
 * The file is part of xxx/xxx
 *
 *
 */

namespace dcr;

use Exception;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * 事件
 * @see  https://code.tutsplus.com/tutorials/handling-events-in-your-php-applications-using-the-symfony-eventdispatcher-component--cms-31328
 */
class EventInstance
{
    public static $event;

    /**
     * @throws Exception
     */
    public static function instance()
    {
        if (!self::$event) {
            $ins         = new EventDispatcher;
            self::$event = $ins;
            return self::$event;
        }

        return self::$event;
    }
}
