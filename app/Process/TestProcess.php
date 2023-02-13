<?php
declare(strict_types=1);


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