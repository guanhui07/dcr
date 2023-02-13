## 中间件

本框架使用 `middlewares/utils` composer包实现 中间件,管道模式，洋葱模型

 

## 路由注解和中间件注解
```php
    /**
     * 测试路由注解
     * 测试中间件注解
     * @return string
     */
    #[RequestMapping(methods: "GET , POST", path:"/index/test2")]
    #[Middlewares(AuthMiddleware::class, TestMiddleware::class)]
    public function test2(): string
    {
        return 'test 1121';
    }
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

    public function __construct()
    {
        parent::__construct();
    }

    #[RequestMapping(methods: 'GET , POST', path:'/test/middleware')]
    #[Middlewares(AuthMiddleware::class, TestMiddleware::class)]
    public function test(): string
    {
//        $this->testService->testDi();
        return apiResponse([]);
    }
}

```

## 多个中间件注解
```php
#[RequestMapping(methods: 'GET , POST', path:'/test/middleware')]
#[Middlewares(AuthMiddleware::class, TestMiddleware::class)]
public function test(): string
{
//        $this->testService->testDi();
    return apiResponse([]);
}
```


## 中间件定义
```php
<?php
declare(strict_types = 1);


namespace app\Middleware;

use app\Exception\RuntimeException;
use app\Middleware\Contract\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public static string $name = 'auth';

    public function handle(): \Closure
    {
        return static function ($request, $next) {
            //            if($isNotLogin){
            //  throw new RuntimeException('auth error');
            //            }
            return $next->handle($request);
        };
    }
}


```
