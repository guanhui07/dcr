<?php
declare(strict_types = 1);
/**
 * The file is part of Dcr/framework
 *
 *
 */

namespace Dcr;

use App\Event\TestEvent;
use App\Listener\TestEventListener;
use App\Provider\EventServiceProvider;
use App\Utils\Config;
use Dcr\Annotation\RouteAnnotation;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Hyperf\AopIntegration\ClassLoader;
use Illuminate\Database\Capsule\Manager as Capsule;

use Symfony\Component\DependencyInjection\ContainerBuilder as SymfonyContainerBuilder;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;
use Symfony\Component\EventDispatcher\EventDispatcher;
/**
 * 初始化 注册 各种 env config orm 门面 事件
 * 捕获异常，错误控制
 * Class Boostrap
 */
class Boostrap
{
    public function run(): void
    {
        // 路由分发对象创建
        Router::load([PROJECT_ROOT.'routes']);
        //注解路由 扫描控制器目录 注解路由 解析 add route
        di()->get(RouteAnnotation::class)->handle();

        $this->loadDotEnv();
        \Dcr\Router::load(PROJECT_ROOT.'routes');

        $config = Config::get('app');
        define('DEBUG', $config['debug']); // online set false
        define('DCR_CONFIG', $config);

        date_default_timezone_set('PRC');
//        date_default_timezone_set('Asia/shanghai');


        if (DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_error', 'On');
        } else {
            error_reporting(0);
            ini_set('display_error', 'Off');
        }

//        set_error_handler(static function ($level, $message, $file = '', $line = 0) {
//            if (error_reporting() & $level) {
//                throw new \ErrorException($message, 0, $level, $file, $line);
//            }
//        });

        set_exception_handler('cException');
        // laravel orm
        $this->bootstrapOrm();

        // 门面
        Facade::instance();
        // 事件
        $this->loadEvents();

        // aop
//        ClassLoader::init();
    }

    /**
     * @see https://github.com/illuminate/database
     */
    public function bootstrapOrm(): void
    {
        $configDb = Config::get('db');
        $configDb = $configDb['connections']['mysql'];
        $capsule  = new Capsule;

        $capsule->addConnection([
            'driver' => 'mysql', 'host' => $configDb['hostname'],
            'database' => $configDb['database'],
            'username' => $configDb['username'],
            'password' => $configDb['password'],
            'charset' => 'utf8', 'collation' => 'utf8_unicode_ci', 'prefix' => '',
        ]);

        // Make this Capsuleinstance available globally via static methods...
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM...
        $capsule->bootEloquent();
    }

    /**
     * 加载dot env
     * @see https://github.com/vlucas/phpdotenv
     */
    protected function loadDotEnv(): void
    {
        $dotenv = Dotenv::createImmutable(PROJECT_ROOT);
        $dotenv->safeLoad();
    }

    /**
     * 事件
     * @see  https://www.doctrine-project.org/projects/doctrine-event-manager/en/latest/reference/index.html#setup
     */
    protected function loadEvents(): void
    {
        $dispatcher = EventInstance::instance();
        $configs = EventServiceProvider::getEventConfig();
        foreach($configs as $eventClass =>$listenerClass)
        {
            $listener = new  $listenerClass();
            $dispatcher->addListener($eventClass::NAME, [$listener, 'process']);
        }
//        $listener = new  TestEventListener();
//        $dispatcher->addListener(TestEvent::NAME, [$listener, 'process']);
    }
}
