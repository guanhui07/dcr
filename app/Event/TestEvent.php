<?php
declare(strict_types = 1);

namespace app\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class TestEvent
 * @package app\Event
 */
class TestEvent extends Event
{
    public const NAME = 'order.placed';

    protected $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function getParams()
    {
        return $this->params;
    }
}