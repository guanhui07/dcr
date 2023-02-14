<?php
declare(strict_types = 1);

//namespace App\Command;

require_once('./vendor/autoload.php');

use App\Console\BaseInterface;
use App\Utils\Config;
use App\Worker\Events;
use Dcr\Container;
use GatewayWorker\BusinessWorker;
use GatewayWorker\Gateway;
use GatewayWorker\Register;
use Workerman\Worker;

define('PROJECT_ROOT', dirname(__DIR__).'/');


class BaseCommand
{
    public function __construct()
    {
        $container = Container::instance();

        // 初始化config env  db orm  facade门面
        $bootstrap = $container->make(\Dcr\Boostrap::class);
        $bootstrap->run();
    }

    public function handle(): void
    {
        // TODO: Implement handle() method.
    }
}

/**
 * Class startWs
 * php ./app/Command/Ws.php start
 * @see https://www.workerman.net/doc/gateway-worker/business-worker.html
 */
class startWs extends BaseCommand implements BaseInterface
{
    public function __construct(){
        parent::__construct();
    }


    public function handle():void
    {
//        global $argv;
        //        $action = $this->argument('action');
        //
        //        $argv[0] = 'wk';
        //        $argv[1] = $action;
        //        $argv[2] = $this->option('d') ? '-d' : '';

        $this->start();
    }

    private function start()
    {
        $config = Config::get('gateway_worker');
        $this->startGateWay($config);
        $this->startBusinessWorker($config);
        $this->startRegister($config);
        Worker::runAll();
    }

    /**
     * @see https://www.workerman.net/doc/gateway-worker/business-worker.html
     */
    private function startBusinessWorker($config): void
    {
        $worker                  = new BusinessWorker();
        $worker->name            = $config['name'] ?? 'dcr';
        $worker->count           = $config['businessWorker']['count'] ?? 4;
        $worker->registerAddress = $config['registerAddress'];
        /**
         * @see https://www.workerman.net/doc/gateway-worker/on-worker-start.html
         */
        $worker->eventHandler    = $config['businessWorker']['eventHandler'];
    }

    /**
     * @see https://www.workerman.net/doc/gateway-worker/gateway.html
     */
    private function startGateWay($config): void
    {
        // wssocket 端口
        $gateway                       = new Gateway("websocket://". $config['host'].':'. $config['port']);
        $gateway->name                 = 'Gateway';
        $gateway->count                = $config['count'] ?? 4;
        $gateway->lanIp                = '127.0.0.1';
        $gateway->startPort            = 2300;

        $gateway->pingInterval         = $config['pingInterval'] ?? 40;
        $gateway->pingNotResponseLimit = $config['pingNotResponseLimit'] ?? 0;
        $gateway->pingData             = $config['pingData'] ?? '{"type":"@heart@"}';

        $gateway->registerAddress      = $config['registerAddress'];
    }

    /**
     * @return Register
     * @see https://www.workerman.net/doc/gateway-worker/register.html
     */
    private function startRegister($config): Register
    {
        $data = explode(':',$config['registerAddress']);
        $port = end($data);
        return new Register('text://'.$config['host'].':'.$port);
    }

}

$o = new startWs();
$o->handle();


