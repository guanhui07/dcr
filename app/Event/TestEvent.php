<?php
declare(strict_types = 1);

namespace app\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class TestEvent
 * @package app\Event
 * @see https://code.tutsplus.com/tutorials/handling-events-in-your-php-applications-using-the-symfony-eventdispatcher-component--cms-31328
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