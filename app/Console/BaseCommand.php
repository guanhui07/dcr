<?php declare(strict_types=1);
/**
 * The file is part of dcr/framework
 *
 *
 */

namespace app\Console;

require_once('./vendor/autoload.php');

use dcr\Container;

class BaseCommand
{
    public function __construct()
    {
        $container = Container::instance();

        // 初始化config env  db orm  facade门面
        $bootstrap = $container->make(\dcr\Boostrap::class);
        $bootstrap->run();
    }

     public function handle(): void
     {
         // TODO: Implement handle() method.
     }
}
