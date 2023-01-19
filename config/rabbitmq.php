<?php
return [
    // 连接信息
    'AMQP' => [
        'host' => '127.0.0.1',
        'port' => '5672',
        'username' => 'guest',
        'password' => 'guest',
        'vhost' => '/',
    ],

    // 订单队列
    'order_queue' => [
        'exchange_name' => 'topic_exchange',
        'exchange_type' => 'topic',
        'queue_name' => 'order_queue',
        'route_key' => '*.order',
        'consumer_tag' => 'order',
    ],
    // /mq/test1
    'test_pay_queue' => [
        'exchange_name' => 'topic_exchange',
        'exchange_type' => 'topic',
        'route_key' => 'test_pay.exchange',
        'queue_name' => 'test_pay.exchange.test_pay_queue',
        'consumer_tag' => 'test_pay',
    ],
];