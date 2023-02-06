<?php declare(strict_types=1);
/**
 * The file is part of dcr/framework
 *
 *
 */

namespace app\Utils;

use app\Model\UserModel;
use Exception;
use GatewayClient\Gateway;

/**
 * Class Socket
 * @see https://www.workerman.net/doc/gateway-worker/on-worker-start.html
 */
class Socket
{
    public static function handle($client_id, $data, $handle)
    {
        $result              = 'ping';
        $client['client_id'] = $client_id;
        $client['data']      = $data;
        $client['data_type'] = gettype($data);
        $client['handle']    = $handle;
        try {
            if (is_string($data)) {
                $client['data_length'] = strlen($data);
                $json_data             = json_decode($data, true);
                if (is_array($json_data) || is_object($json_data)) {
                    $client['json_data'] = json_decode($data, true);
                } else {
                    $client['string_data'] = json_decode($data, true);
                }
            }
        } catch (Exception $e) {
            $client['error'] = $e->getMessage();
            // self::saveLog($client, $client_id);
        }
        if (!$handle) {
            $result = '非法访问';
        }
        if ($data) {
            // try{
            $resultData           = self::index($client_id, $data, $handle);
            $client['function']   = 'index()';
            $client['resultData'] = $resultData;
            // 如果出现参数错误，检查$resultData['data']是否输出字符串
            if (!is_string($resultData['data'])) {
                throw new Exception(json_encode($resultData), 10001);
            }
            $result = $resultData['data'];
            self::saveLog($client, $client_id);
        } else {
            $result             = $data;
            $client['function'] = 'NULL';
            $client['result']   = $data;
            // save_log($client, $client_id);
        }
        return $result;
    }

    private static function index($client_id, $data, $handle)
    {
        echo 'into index 992';
        // 链路有效时长(s)
        $client_length        = 120;
        $result['status']     = 200;
        $result['message']    = '连接成功';
        $content['handle']    = $handle;
        $content['client_id'] = $client_id;
        // 握手事件
        if ($handle === 'onWebSocketConnect') {
            $content['data'] = $data;
            $user            = [];
            if (isset($data['get']['token'])) {
                $content['token'] = $token = $data['get']['token'];
                //                $user = KypUserModel::field('id')->where('access_token',stripslashes($token))->find();
                //todo:
                $user = Redis::connection()->get(stripslashes($data['get']['token']));
                if (Enviroment::isRoyeeDev()) {
                    $user = UserModel::where('id', 160709)->first();
                }
                if ($user) {
                    $user = UserModel::where('id', $user['id'])->first();
                } else {
                    return [];
                }

                Gateway::bindUid($client_id, $user->id);
            }
            if (!$user) {
                //关闭连接
                Gateway::$registerAddress = '127.0.0.1:1236';
                Gateway::closeClient($client_id);
                $result['status']  = 404;
                $result['message'] = 'token无效或已过期';
                return $result;
            }
            // 缓存数据只保留1天
            Redis::connection()->set('client_user_id_'.$client_id, $user['id'], 86400);
            Redis::connection()->set('client_id_'.$user['id'], $client_id, 86400);
        }
        // 消息事件
        if ($handle === 'onMessage') {
            $data   = json_decode($data, true);
            $userId = Redis::connection()->get('client_user_id_'.$client_id);
            if (!$userId) {
                //关闭连接
                Gateway::$registerAddress = '127.0.0.1:1236';
                Gateway::closeClient($client_id);
                $result['status']  = 404;
                $result['message'] = 'token无效或已过期';
                return $result;
            }
            if (isset($data['blindbox_id'])) {
                // 查询是否存在上次在线盲盒id，存在则先移出分组
                $lastClientUserBlindboxId = Redis::connection()->get('client_user_blindbox_id_'.$userId);
                if ($lastClientUserBlindboxId) {
                    $lastGroupName = 'client_blindbox_id_'.$lastClientUserBlindboxId;
                    Gateway::leaveGroup($client_id, $lastGroupName);
                }
                // 设置当前最新在线盲盒id
                Redis::connection()->set('client_user_blindbox_id_'.$userId, $data['blindbox_id'], 86400);
                $content['blindbox_id'] = $data['blindbox_id'];
                $groupName              = 'client_blindbox_id_'.$data['blindbox_id'];
                Gateway::joinGroup($client_id, $groupName);
            }
            if (isset($data['room_id'])) {
                // 查询是否存在上次在线盲盒id，存在则先移出分组
                $lastClientUserRoomId = Redis::connection()->get('client_user_room_id_'.$userId);
                if ($lastClientUserRoomId) {
                    $lastGroupName = 'client_room_id_'.$lastClientUserRoomId;
                    Gateway::leaveGroup($client_id, $lastGroupName);
                }
                // 设置当前最新在线盲盒房间id
                Redis::connection()->set('client_user_room_id_'.$userId, $data['room_id'], 86400);
                $content['room_id'] = $data['room_id'];
                $groupName          = 'client_room_id_'.$data['room_id'];
                Gateway::joinGroup($client_id, $groupName);
            }
            if (isset($data['order_id'])) {
                // 查询是否存在订单id，存在则先移出分组
                $lastClientUserOrderId = Redis::connection()->get('client_user_order_id_'.$userId);
                if ($lastClientUserOrderId) {
                    $lastGroupName = 'client_order_id_'.$lastClientUserOrderId;
                    Gateway::leaveGroup($client_id, $lastGroupName);
                }
                // 设置当前最新在线盲盒id
                Redis::connection()->set('client_user_order_id_'.$userId, $data['order_id'], 86400);
                $content['order_id'] = $data['order_id'];
                $groupName           = 'client_order_id_'.$data['order_id'];
                Gateway::joinGroup($client_id, $groupName);
            }
            $content['data'] = $data;
        }
        // 关闭事件
        if ($handle === 'onClose') {
            $userId = Redis::connection()->get('client_user_id_'.$client_id);
            if ($userId) {
                Redis::connection()->del('client_user_id_'.$client_id);
                Redis::connection()->del('client_id_'.$userId);
                Redis::connection()->del('client_user_blindbox_id_'.$userId);
                Redis::connection()->del('client_user_room_id_'.$userId);
                Redis::connection()->del('client_blindbox_id_'.$userId);
                Redis::connection()->del('client_room_id_'.$userId);
            }
            // $userId = Redis::connection()->get('client_user_id_'.$client_id);
            // if($userId){
            //     Redis::connection()->del('client_user_id_'.$client_id);
            // }
        }
        $result['content'] = $content;
        $result['data']    = json_encode($result);
        // self::saveLog($result, $client_id);
        return $result;
    }

    /**
     * @param $params
     *
     * @throws Exception
     * @see  https://www.workerman.net/doc/gateway-worker/work-with-other-frameworks.html#%E5%85%B3%E4%BA%8EGatewayClient
     */
    private static function client($params): void
    {
        $client_id         = $fd = 1;
        $uid               = 17;
        $group             = $groupName = 'test_group';
        $exclude_client_id = $raw = null;
        $data              = ['abc' => 'test'];
        // 发送数据
        Gateway::$registerAddress = '127.0.0.1:1236';
        // 绑定uid fd
        Gateway::bindUid($fd, $uid);
        Gateway::unbindUid($fd, $uid);
        //关闭连接
        Gateway::closeClient($client_id);
        // 发送给绑定的uid
        Gateway::sendToUid(1, $data);
        // 加入群组，$groupName可以是任何类型，包括字符串或者数字
        Gateway::joinGroup($client_id, $groupName);
        // 将client_id从某个组中删除，不再接收该分组广播(Gateway::sendToGroup)发送的数据(当client_id下线（连接断开）时，client_id会自动从它所属的各个分组中删除)
        Gateway::leaveGroup($client_id, $groupName);
        // 向某个分组的所有在线client_id发送数据
        // $exclude_client_id,$raw可以为空
        // $exclude_client_id client_id组成的数组。$exclude_client_id数组中指定的client_id将被排除在外，不会收到本次发的消息
        // $raw 是否发送原始数据，也就是绕过gateway协议打包过程，gateway对数据不再做任何处理，直接发给客户端
        Gateway::sendToGroup($groupName, $data, $exclude_client_id, $raw);
        // 直接发送给指定client_id
        Gateway::sendToClient($fd, $data);
        // 发送给全部
        $result['code']    = 404;
        $result['message'] = "{$client_id}下线了 ";
        GateWay::sendToAll(json_encode($result, JSON_UNESCAPED_UNICODE));
        // 获得该组所有在线成员数据
        Gateway::getClientSessionsByGroup($groupName);
        // 获得该组所有在线连接数（人数）
        Gateway::getClientCountByGroup($groupName);
        // 解散分组
        Gateway::ungroup($group);
        // 判断某个uid是否在线
        Gateway::isUidOnline($uid);
        //获取与 uid 绑定的 client_id 列表
        Gateway::getClientIdByUid($uid);
        // 判断client_id对应的连接是否在线
        Gateway::isOnline($client_id);
        //
        Gateway::destoryClient($client_id);
        // 通过client_id获取uid
        Gateway::getUidByClientId($client_id);
        //
        Gateway::getAllClientInfo('');
        //
        Gateway::getClientInfoByGroup('');
        // 获取所有在线client_id数
        Gateway::getAllClientIdCount();
        // 获取所有在线client_id数(getAllClientIdCount的别名)
        Gateway::getAllClientCount();
        // 获取全局在线uid列表
        Gateway::getAllUidList();
        //
        Gateway::getAllGroupIdList();
        // 获取全局在线uid数
        Gateway::getAllUidCount();
        //
        Gateway::getAllGroupUidCount();
        // 获取某个组的在线client_id数
        Gateway::getClientIdCountByGroup('');
        // 获取某个群组在线client_id列表
        Gateway::getClientIdListByGroup('');
        // 获取某个群组在线uid列表
        Gateway::getUidListByGroup('');
        // 获取某个群组在线uid数
        Gateway::getUidCountByGroup('');
        // 获取集群所有在线client_id列表
        Gateway::getAllClientIdList();
    }

    private static function saveLog($data, $client_id)
    {
        return true;
        //        return save_log($data, 'public/log/socket/handle_' . $client_id . '.log');
    }
}
