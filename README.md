

# dcr框架 - 整合各个包，然后模仿laravel 骨架 造的一个简单框架骨架
- 集成 laravel orm , restful route, predis, guzzle monolog 
- rabbitmq, workerman websocket
- container  facade
-  console   
-  migrate 
-  event
- crontab
- middleware
- validate
- monolog
- collection  carbon
- dotenv

http: 生产不推荐，推荐使用nginx
```
php -S 127.0.0.1:8001 -t ./public  
```
websocket: 基础于workerman gateway
```
php ./bin/startWs.php start   
```
crontab: 基础于workerman crontab
```
php ./bin/crontab.php start  == composer crontab
```


command 应用
```
php artisan test2
```


默认路由 ，不推荐
http://127.0.0.1:8001/?r=test/test2

restful路由
http://127.0.0.1:8001/test


## 依赖如下组件 并查阅文档 使用 组合了 此框架
```
"illuminate/database": "^8.83",    laravel orm 
"qiniu/php-sdk": "^7.6",        qiniu-sdk
"vlucas/phpdotenv": "^5.4",     dotenv
"predis/predis": "^2.0",        redis client
"guzzlehttp/guzzle": "^7.5",     guzzle client http
"php-amqplib/php-amqplib": "dev-master",   rabbitmq
"workerman/gatewayclient": "^3.0",    workerman websocket client
"workerman/workerman": "^3.5.23",    workerman 基础包 stream fork socket编程 用event扩展性能好
"workerman/gateway-worker": "^3.0.0",   workerman websocket
"monolog/monolog": "^2.8",        monolog  日志
"nikic/fast-route": "^1.3",      restful route 路由
"illuminate/support": "^8.83"   laravel collect  carbon
doctrine/instantiator 实例化对象不走 构造 
"inhere/php-validate": "^2.8",   inhere的验证器
"php-di/php-di": "^6.4",  容器 依赖注入 底层反射  
"guanhui07/facade": "^1.0"  门面  底层魔术方法__callStatic
"workerman/crontab": "^1.0" crontab 秒级定时任务 ，timer 用event扩展性能好
"doctrine/migrations": "^3.5"  数据库文件迁移 
"doctrine/event-manager": "^1.1",  事件 监听 观察者模式  解耦，比如事件投递 任务消费 
"middlewares/utils": "^3.3",  中间件 解耦 比如auth cors rate_limit
"inhere/console": "^4.0",    console 命令应用
"fzaninotto/faker": "^1.5",   fake 数据   
"nesbot/carbon": "^2.64"  carbon
"opis/closure": "^3.6",  序列化闭包 https://opis.io/closure/3.x/serialize.html
"symfony/finder": "^6.2",     
"symfony/console": "^5.1",   命令行应用
"symfony/http-kernel": "^6.2",  request response
"intervention/image": "^2.7",    图片处理 水印 缩略图
"gregwar/captcha": "^1.1",   验证码
"elasticsearch/elasticsearch": "7.16",  es
```

## demo
```
./app/TestController.php
```


## test
```
composer test
```


