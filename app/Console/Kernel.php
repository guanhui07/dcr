<?php
declare(strict_types = 1);
/**
 * The file is part of dcr/framework
 *
 *
 */

namespace app\Console;

/**
 * 所有的命令类注册 类
 * Class Kernel
 * @package app\Console
 */
class Kernel
{
    /**
     * @see https://github.com/inhere/php-console/wiki
     */
    public static function getCommands(): array
    {
        return [
            \app\Console\Command\TestCommand::class,
            \app\Console\Command\Test2Consumer::class,
        ];
    }
}
