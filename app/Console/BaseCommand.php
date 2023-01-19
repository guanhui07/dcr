<?php

namespace app\Console;

require_once('./vendor/autoload.php');

use dcr\Container;

//use Illuminate\Console\Command;

 class BaseCommand
{
    public function __construct()
    {
        $container = Container::instance();

        // 初始化config env  db orm  facade门面
        $bootstrap = $container->make(\dcr\Boostrap::class);
        $bootstrap->run();
    }

     public function handle()
     {
         // TODO: Implement handle() method.
     }
 }




