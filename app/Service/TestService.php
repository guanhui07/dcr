<?php
declare(strict_types = 1);
/**
 * The file is part of dcr/framework
 *
 *
 */

namespace app\Service;

use app\Repository\TestRepository;
use DI\Attribute\Inject;

/**
 * Class TestService
 * @package app\Service
 */
class TestService
{
    /**
     * php8注解 注入
     * @var TestRepository
     */
    #[Inject]
    public TestRepository $testRepository;

    /**
     * 构造方式注入
     * TestService constructor.
     *
     * @param  TestRepository  $t
     */
    public function __construct(TestRepository $t)
    {
//        $this->testRepository = $t;
    }

    public function testDi(): void
    {
        echo 'test Di';
        echo PHP_EOL;
        $this->testRepository->fromRepos();
    }
}
