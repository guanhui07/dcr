<?php declare(strict_types=1);
/**
 * The file is part of Dcr/framework
 *
 *
 */

namespace App\Worker;

use App\Utils\Json;
use App\Utils\Socket;
use Exception;
use GatewayClient\Gateway;
use Workerman\Worker;

/**
 * Class Events
 * @package App\Worker
 * @see https://www.workerman.net/doc/gateway-worker/on-worker-start.html
 */
class Events
{
    /**
     * onWorkerStart 事件回调
     * 当businessWorker进程启动时触发。每个进程生命周期内都只会触发一次
     */
    public static function onWorkerStart(Worker $businessWorker): void
    {
        // tp
        //        $app = new Application;
        //        $app->initialize();
    }

    /**
     * onConnect 事件回调
     * 当客户端连接上gateway进程时(TCP三次握手完毕时)触发
     *
     * @param  int  $client_id
     *
     * @throws Exception
     */
    public static function onConnect($client_id): void
    {
        Socket::handle($client_id, '', 'onConnect');
    }

    /**
     * onWebSocketConnect 事件回调
     * 当客户端连接上gateway完成websocket握手时触发
     *
     * @param  integer  $client_id  断开连接的客户端client_id
     * @param  mixed  $data
     *
     * @return void
     * @throws Exception
     */
    public static function onWebSocketConnect($client_id, $data): void
    {
        try {
            //处理连接绑定
            Gateway::sendToClient($client_id, 'websocket connect ok');
            //            var_dump($_GET);
            //            echo PHP_EOL;
            $result = Socket::handle($client_id, $data, 'onWebSocketConnect');
            Gateway::sendToClient($client_id, $result);
        } catch (Exception $exception) {
            Socket::handle($client_id, $exception, 'onWebSocketConnectCloseClient');
            //关闭连接
            Gateway::closeClient($client_id);
        }
    }

    /**
     * @param  int  $client_id
     * @param  mixed  $data
     *
     * @throws Exception
     */
    public static function onMessage($client_id, $data): void
    {
        //处理用户之间的相互通信
        $result = Socket::handle($client_id, $data, 'onMessage');
        Gateway::sendToClient($client_id, Json::encode(['ret' => $result, 'ignore' => 1]));
    }

    /**
     * @param $client_id
     *
     * @throws Exception
     */
    public static function onClose($client_id): void
    {
        Socket::handle($client_id, '', 'onClose');
    }

    /**
     * @param  Worker  $businessWorker
     */
    public static function onWorkerStop(Worker $businessWorker): void
    {
        // $result = Socket::handle('','','WorkerStop');
    }
}
