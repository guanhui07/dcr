<?php
declare(strict_types = 1);

//namespace app\Command;

require_once('./vendor/autoload.php');

use app\Repository\TestRepository;
use dcr\Boostrap;
use dcr\Container;
use Workerman\Crontab\Crontab as WmCrontab;
use Workerman\Worker;

define('PROJECT_ROOT', dirname(__DIR__).'/');
! defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1));
$container = Container::instance();

// 初始化 注册 config env  db orm  facade门面
/** @var Boostrap $bootstrap */
$bootstrap = $container->make(Boostrap::class);
$bootstrap->run();
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
//            new WmCrontab('*/1  * * * * *', function(){
//                echo date('Y-m-d H:i:s')."\n";
//            });
            new WmCrontab('*/1  * * * * *', function(){
                di()->get(TestRepository::class)->test();
            });

        };

        Worker::runAll();
    }
}

(new crontab())->run();

