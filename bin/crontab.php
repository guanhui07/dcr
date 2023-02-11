<?php
declare(strict_types = 1);

require_once('./vendor/autoload.php');

use dcr\Boostrap;
use dcr\Container;
use Workerman\Crontab\Crontab as WmCrontab;
use Workerman\Worker;

define('PROJECT_ROOT', dirname(__DIR__).'/');
!defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1));
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
        $worker = new Worker();

        $worker->onWorkerStart = static function () {
            $allCrontab = config('crontab.crontab');
            foreach ($allCrontab as $k => $crontab) {
                new WmCrontab($crontab[0], function () use ($crontab) {
                    di()->get($crontab[1])->execute();
                });
            }
        };

        Worker::runAll();
    }

}

(new crontab())->run();

