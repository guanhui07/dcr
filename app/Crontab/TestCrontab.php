<?php
declare(strict_types = 1);

namespace app\Crontab;


use app\Crontab\Contract\CrontabInterface;
use app\Repository\TestRepository;

/**
 *
 * 需要在 /config/crontab.php 配置
 * Class TestCrontab
 * @package app\Crontab
 */
class TestCrontab implements CrontabInterface
{
    public string $name = 'test';
    public string $desc = 'just test demo';

    public function execute(): void
    {
        echo 'test crontab'.PHP_EOL;
//        di()->get(TestRepository::class)->test1();
//        di()->get(TestRepository::class)->fromRepos();
    }
}