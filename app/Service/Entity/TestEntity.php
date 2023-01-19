<?php
declare(strict_types = 1);

namespace app\Service\Entity;

use app\Utils\SplBean;

class TestEntity extends SplBean
{
    /**
     * @var ExchGiftInfo
     */
    public ExchGiftInfo $gift;

    public string $msg;

    public int $user_id;

}