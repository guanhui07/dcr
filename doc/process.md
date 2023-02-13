## process

```php
<?php


namespace App\Console\Command;

use App\Process\TestProcess;
use Dcr\Process\ProcessManager;
use Inhere\Console\Command;
use Inhere\Console\IO\Input;
use Inhere\Console\IO\Output;
use Toolkit\PFlag\FlagsParser;

/**
 * php artisan process
 */
class ProcessCommand extends Command
{
    protected static string $name = 'process';
    protected static string $desc = 'print system ENV information';
    protected function configFlags(FlagsParser $fs): void
    {
    }

    /**
     * 通过 pcntl_fork 实现 原生支持多进程
     */
    protected function execute(Input $input, Output $output): void
    {
        // mac、win下面只支持一个 ，linux下支持 多个
        // https://www.workerman.net/q/8638 workerman 下也有此问题
        $processNum = 3;
        di()->get(ProcessManager::class)->run(TestProcess::class,$processNum);
    }
}

```


```php
<?php
namespace App\Process;
use Carbon\Carbon;
class TestProcess implements ProcessInterface
{
    public function hook()
    {
        while (true) {
            echo 'process ts1 ' . Carbon::now()->toDateTimeString().PHP_EOL;
            sleep(1);
        }
    }
}
```