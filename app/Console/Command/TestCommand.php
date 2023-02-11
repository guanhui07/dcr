<?php
declare(strict_types = 1);
/**
 * The file is part of dcr/framework
 *
 *
 */

namespace app\Console\Command;

use Inhere\Console\Command;
use Inhere\Console\IO\Input;
use Inhere\Console\IO\Output;
use Toolkit\PFlag\FlagsParser;

/**
 * php artisan test
 */
class TestCommand extends Command
{
    protected static string $name = 'test';

    protected static string $desc = 'print system ENV information';

    protected function configFlags(FlagsParser $fs): void
    {
        // 绑定选项
        $fs->addOptByRule('update, up', 'bool;update linux command docs to latest');
        $fs->addOptByRule('init, i', 'bool;update linux command docs to latest');
        $fs->addOptByRule('search, s', 'string;input keywords for search');

        // 绑定参数
        // - 这里没有设置必须 可以不传，获取到就是空string
        $fs->addArg('keywords', 'the keywords for search or show docs', 'string');
    }

    protected function execute(Input $input, Output $output): void
    {
        $keywords = $this->flags->getOpt('search', 23);
        var_dump($keywords);
//
//        $name = $this->flags->getFirstArg();
//        if ( !$name && !$keywords) {
//            // env | grep XXX
//            $output->aList($_SERVER, 'ENV Information', ['ucFirst' => false]);
//            return;
//        }

        $output->info('hello world ...');
    }
}
