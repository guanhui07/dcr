<?php
declare(strict_types = 1);

namespace app\Service;

use app\Repository\TestRepository;

/**
 * Class TestService
 * @package app\Service
 */
class TestService
{
    public TestRepository $testRepository;

    public function __construct(TestRepository $t)
    {
        $this->testRepository = $t;
    }

    public function testDi()
    {
        echo 'test Di';
        echo PHP_EOL;
        $this->testRepository->fromRepos();
    }
}