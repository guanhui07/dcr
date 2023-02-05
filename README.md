

# dcr框架 - 整合各个包，然后模仿laravel 骨架 实现的框架
- 集成 laravel orm , restful route, predis, guzzle monolog 
- rabbitmq, workerman websocket
- container  facade
-  console   
-  migrate 
-  event
- crontab
- middleware  中间件注解
- validate
- monolog
- collection  carbon
- dotenv
- PHP8特性attributes实现了路由注解  

### 安装
```
composer create-project dcr/framework skeleton
```

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

## 路由注解 和 中间件注解 以及Inject注解  使用
```php
<?php declare(strict_types=1);

namespace app\Controller;

use app\Middleware\AuthMiddleware;
use app\Middleware\TestMiddleware;
use app\Service\TestService;
use dcr\Annotation\Mapping\Middlewares;
use dcr\Annotation\Mapping\RequestMapping;
use DI\Attribute\Inject;

class MIddlewareController extends Controller
{
    #[Inject]
    public TestService $testService;

    #[RequestMapping(methods: 'GET , POST', path:'/test/middleware')]
    #[Middlewares(AuthMiddleware::class, TestMiddleware::class)]
    public function test1()
    {
//        $this->testService->testDi();
        return apiResponse([]);
    }
}
```

## 从容器 拿对象 获取 参数
```php
//->all()  ->get()  ->post() 等方法
ApplicationContext::getContainer()->get(Request::class)->all();
//di()->(Request::class)->all();
```

## redis 操作
```php
$redis = Redis::connection();
//->setex ->get ->del ->setnx 等方法 和predis一致
```

## orm model ，使用和laravel orm一致
```php
<?php
declare(strict_types = 1);
namespace app\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserModel
 * @package app\Model
 * @see https://github.com/illuminate/database
 */
class UserModel extends Model
{
    protected $table = 'user';
}


```
### 控制器validate
```php
   #[RequestMapping(methods: "GET , POST", path:"/test/test4")]
    public function test4($request, $response)
    {
        $validate = Validation::check($this->request->post ?? [], [
            // add rule
            ['title', 'min', 40],
            ['freeTime', 'number'],
        ]);

        if ($validate->isFail()) {
            var_dump($validate->getErrors());
            var_dump($validate->firstError());
        }

        // $postData = $v->all(); // 原始数据
        $safeData = $validate->getSafeData(); // 验证通过的安全数据

        return $safeData
    }
```

### 获取配置 需要`use DI\Attribute\Inject`
```php
    #[Inject]
    public Config $config;

    #[RequestMapping(methods: "GET , POST", path:"/test/config")]
    public function config()
    {
        //di()->get(Config::class)->get('app.debug');
        return $this->config->get('app.debug');
    }
```

## 中间件 需要`app/Middleware/Kernel.php` 配置
```php
<?php

namespace app\Middleware;

use app\Exception\RuntimeException;
use app\Middleware\Contract\MiddlewareInterface;

class TestMiddleware implements MiddlewareInterface
{
    public function handle()
    {
        return static function ($request, $next) {
//            throw new RuntimeException('未登录');
            $response = $next->handle($request);
            return $response;
        };
    }
}

```

### Console 命令应用 需要在`app/Console/Kernel.php` 配置 命令类
```php
<?php
declare(strict_types = 1);

namespace app\Console\Command;

use Inhere\Console\IO\Input;
use Inhere\Console\IO\Output;
use Toolkit\PFlag\FlagsParser;

class Test2 extends \Inhere\Console\Command
{
    protected static string $name = 'test2';

    protected static string $desc = 'print system ENV information';

    protected function configFlags(FlagsParser $fs): void
    {
        // 绑定选项
        $fs->addOptByRule('update, up', 'bool;update linux command docs to latest');
        $fs->addOptByRule('init, i', 'bool;update linux command docs to latest');
        $fs->addOptByRule('search, s', 'string;input keywords for search');

        // - 这里没有设置必须 可以不传，获取到就是空string
        $fs->addArg('keywords', 'the keywords for search or show docs', 'string');
    }

    protected function execute(Input $input, Output $output): void
    {
        $keywords = $this->flags->getOpt('search', 23);
        var_dump($keywords);
        $output->info('hello world ...');
    }
}

```




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


