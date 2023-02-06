<?php
declare(strict_types = 1);

namespace app\Listener;


interface BaseListenerInterface
{
    public function process(object $event);
}