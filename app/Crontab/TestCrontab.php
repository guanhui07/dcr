<?php
declare(strict_types = 1);

namespace App\Crontab;


use App\Crontab\Contract\CrontabInterface;
use App\Repository\TestRepository;

/**
 *
 * 需要在 /config/crontab.php 配置
 * Class TestCrontab
 * @package App\Crontab
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