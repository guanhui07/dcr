<?php
declare(strict_types = 1);

namespace app\Crontab\Contract;

interface CrontabInterface
{
    public function execute();
}