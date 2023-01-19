<?php
declare(strict_types = 1);

//namespace app\Command;

require_once('./vendor/autoload.php');

use dcr\Container;
use Workerman\Crontab\Crontab as WmCrontab;
use Workerman\Worker;

/**
 * @see https://github.com/walkor/crontab
 * Class Crontab
 * @package app\Command
 */
class crontab
{
    public function run()
    {
//        $container = Container::instance();
//
//        // 初始化 注册 config env  db orm  facade门面
//        //(new \dcr\Boostrap())->run();
//        /** @var \dcr\Boostrap $bootstrap */
//        $bootstrap = $container->make(\dcr\Boostrap::class);
//        $bootstrap->run();
//
//        \dcr\CommandDcr::bootstrap();


        $worker = new Worker();

        $worker->onWorkerStart = static function () {
            $phpPath = '/usr/local/Cellar/php/8.1.9/bin/php  ';
            $artisanPath = dirname(__DIR__).'/artisan ';
            $comand = $phpPath . $artisanPath;
            // Execute the function in the first second of every minute.
            new WmCrontab('*/1  * * * * *', function(){
                echo date('Y-m-d H:i:s')."\n";
            });

            //每2秒执行一次
            new WmCrontab('*/2  * * * * *', function()use ($comand){
                $output= shell_exec( $comand .'test2');
                var_dump($output);
            });
        };

        Worker::runAll();
    }
}

(new crontab())->run();

