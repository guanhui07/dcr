<?php
declare(strict_types = 1);

namespace app\Middleware\Contract;

interface MiddlewareInterface
{
    public function handle();
}