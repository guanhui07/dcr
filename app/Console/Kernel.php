<?php
declare(strict_types = 1);
/**
 * The file is part of Dcr/framework
 *
 *
 */

namespace App\Console;

/**
 * 所有的命令类注册 类
 * Class Kernel
 * @package App\Console
 */
class Kernel
{
    /**
     * @see https://github.com/inhere/php-console/wiki
     */
    public static function getCommands(): array
    {
        return [
            \App\Console\Command\TestCommand::class,
            \App\Console\Command\Test2Consumer::class,
            \App\Console\Command\ProcessCommand::class,
        ];
    }
}
