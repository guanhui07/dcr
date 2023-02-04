<?php declare(strict_types=1);
/**
 * The file is part of xxx/xxx
 *
 *
 */

namespace dcr;

use Guanhui07\Facade\FacadeFactory;

/**
 * Facade 门面管理类
 * @see https://github.com/guanhui07/facade
 */
class Facade
{
    /**
     * @var \DI\Container
     */
    public static $ins;

    public static function instance(): \DI\Container
    {
        if (!self::$ins) {
            $container = Container::instance();
            FacadeFactory::setContainer($container);
            self::$ins = $container;
            return self::$ins;
        }

        return self::$ins;
    }
}
