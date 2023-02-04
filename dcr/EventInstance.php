<?php
declare(strict_types = 1);
/**
 * The file is part of xxx/xxx
 *
 *
 */

namespace dcr;

use Doctrine\Common\EventManager;
use Exception;

/**
 * 事件
 * @see  https://www.doctrine-project.org/projects/doctrine-event-manager/en/latest/reference/index.html#setup
 */
class EventInstance
{
    /**
     * @var EventManager
     */
    public static $ins;

    /**
     * @throws Exception
     */
    public static function instance()
    {
        if (!self::$ins) {
            $ins       = new EventManager;
            self::$ins = $ins;
            return self::$ins;
        }

        return self::$ins;
    }
}
