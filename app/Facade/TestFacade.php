<?php
declare(strict_types = 1);
/**
 * The file is part of xxx/xxx
 *
 *
 */

namespace app\Facade;

use app\Service\Test2Service;
use Guanhui07\Facade\AbstractFacade;

/**
 * 门面
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
