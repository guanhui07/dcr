<?php
declare(strict_types = 1);
/**
 * The file is part of xxx/xxx
 *
 *
 */

namespace app\Console\Command;

use Inhere\Console\IO\Input;
use Inhere\Console\IO\Output;
use Toolkit\PFlag\FlagsParser;

/**
 * Class Test2
 * @package app\Console\Command
 * php artisan test2
 */
class Test2 extends \Inhere\Console\Command
{
    protected static string $name = 'test2';

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
