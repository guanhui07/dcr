<?php
declare(strict_types=1);

use app\Crontab\TestCrontab;
use Workerman\Crontab\Crontab as WmCrontab;

return [
//    'enable' => $_ENV['crontab_enable'] ?? true,

    'crontab' => [
        ['*/1  * * * * *',TestCrontab::class],

    ],
];