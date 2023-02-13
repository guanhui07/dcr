## crontab

秒级别定时任务，基础于workerman crontab实现 
`workerman/crontab` composer包
底层：`pcntl_alarm` `pcntl扩展` 原生php支持


### crontab定时任务 需要在 `/config/crontab.php` 配置 定时任务
```php
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

```


`/config/crontab.php`

```php
<?php
use App\Crontab\TestCrontab;

return [
    'crontab' => [
        ['*/1  * * * * *',TestCrontab::class],
    ],
]; 
```