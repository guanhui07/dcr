<?php

use App\Worker\Events;

return [
    // 扩展自身需要的配置
    'protocol'              => 'websocket', // 协议 支持 tcp udp unix http websocket text
    'host'                  => '0.0.0.0', // 监听地址
    'port'                  => 16229, // 监听端口 ws://127.0.0.1:16229?token=c4250dc845ef0ab7839c6aa9fd305286
//    'socket'                => '', // 完整监听地址
//    'context'               => [], // socket 上下文选项
//    'register_deploy'       => true, // 是否需要部署register
//    'businessWorker_deploy' => true, // 是否需要部署businessWorker
//    'gateway_deploy'        => true, // 是否需要部署gateway
//
//    // Register配置
    'registerAddress'       => '127.0.0.1:1236',
//
//    // Gateway配置
    'name'                  => 'dcr',
//    //gateway进程数为cpu核数
    'count'                 => 4,
//    'lanIp'                 => '127.0.0.1',
//    'startPort'             => 2000,
//    'daemonize'             => false,
    'pingInterval'          => 55,
    'pingNotResponseLimit'  => 0,//(0服务端发送心跳1客户端发送心跳)
    'pingData'              => '{"type":"@heart@"}',
//
//    // BusinsessWorker配置
    'businessWorker'        => [
        'name'         => 'BusinessWorker',
        'count'        => 8,    //一般 businessWorker进程数为cpu2-3倍即可
        'eventHandler' => Events::class,
    ],

];
