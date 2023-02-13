## crontab

秒级别定时任务，基础于workerman crontab实现 



### crontab定时任务 需要在 `/config/crontab.php` 配置 定时任务
```php
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

```


`/config/crontab.php`

```php
<?php
use app\Crontab\TestCrontab;

return [
    'crontab' => [
        ['*/1  * * * * *',TestCrontab::class],
    ],
]; 
```