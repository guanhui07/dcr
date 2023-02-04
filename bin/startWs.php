<?php
declare(strict_types = 1);

//namespace app\Command;

require_once('./vendor/autoload.php');

use app\Console\BaseCommand;
use app\Console\BaseInterface;
use app\Worker\Events;
use GatewayWorker\BusinessWorker;
use GatewayWorker\Gateway;
use GatewayWorker\Register;
use Workerman\Worker;

define('PROJECT_ROOT', dirname(__DIR__).'/');

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


    public function handle()
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
        $this->startGateWay();
        $this->startBusinessWorker();
        $this->startRegister();
        Worker::runAll();
    }

    /**
     * @see https://www.workerman.net/doc/gateway-worker/business-worker.html
     */
    private function startBusinessWorker(): void
    {
        $worker                  = new BusinessWorker();
        $worker->name            = 'BusinessWorker';
        $worker->count           = 4;
        $worker->registerAddress = '127.0.0.1:1236';
        /**
         * @see https://www.workerman.net/doc/gateway-worker/on-worker-start.html
         */
        $worker->eventHandler    = Events::class;
    }

    /**
     * @see https://www.workerman.net/doc/gateway-worker/gateway.html
     */
    private function startGateWay(): void
    {
        // wssocket 端口
        $gateway                       = new Gateway("websocket://0.0.0.0:16229");
        $gateway->name                 = 'Gateway';
        $gateway->count                = 4;
        $gateway->lanIp                = '127.0.0.1';
        $gateway->startPort            = 2300;

        $gateway->pingInterval         = 30;
        $gateway->pingNotResponseLimit = 0;
        $gateway->pingData             = '{"type":"@heart@"}';

        $gateway->registerAddress      = '127.0.0.1:1236';
    }

    /**
     * @return Register
     * @see https://www.workerman.net/doc/gateway-worker/register.html
     */
    private function startRegister(): Register
    {
        return new Register('text://0.0.0.0:1236');
    }

}

$o = new startWs();
$o->handle();


