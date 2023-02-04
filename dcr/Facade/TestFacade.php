<?php
declare(strict_types = 1);
/**
 * The file is part of xxx/xxx
 *
 *
 */

namespace dcr\Facade;

use app\Service\Test2Service;
use Guanhui07\Facade\AbstractFacade;

/**
 * 门面
 * Class TestFacade
 * @package dcr\Facade
 * @see https://github.com/guanhui07/facade
 */
class TestFacade extends AbstractFacade
{
    /**
     * 不需要实例化直接
     * Test2Service::test1()
     * @return string
     */
    protected static function accessor(): string
    {
        return Test2Service::class;
    }
}
