<?php
declare(strict_types = 1);
/**
 * The file is part of Dcr/framework
 *
 *
 */

namespace App\Service\Entity;

use App\Utils\SplBean;

class TestEntity extends SplBean
{
    /**
     * @var ExchGiftInfo
     */
    public ExchGiftInfo $gift;

    public string $msg;

    public int $user_id;
}
