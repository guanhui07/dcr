## request

### 实现原理



## 示例代码

```php
    #[Inject]
    public DcrRequest $request;
```
```php
    #[RequestMapping(methods: "GET , POST", path:"/index/test2")]
    #[Middlewares(AuthMiddleware::class, TestMiddleware::class)]
    public function test2(): string
    {
         // 测试 request
        $test = $this->request->get('name', 'zhangsan');
        
    }
```
