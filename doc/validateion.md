## validator 

验证器可以有效减少 if else 判断，本框架基础`inhere/php-validate` composer包 实现验证器
[https://github.com/inhere/php-validate](https://github.com/inhere/php-validate)

### 控制器validate
```php
      /**
     * 测试Validate
     * @see https://github.com/inhere/php-validate
     */
    #[RequestMapping(methods: 'GET , POST', path:'/test/test4')]
    public function test4(): string
    {
        $v = Validation::check($_POST, [
            // add rule
            ['title', 'min', 40],
            ['freeTime', 'number'],
        ]);

        if ($v->isFail()) {
            var_dump($v->getErrors());
            var_dump($v->firstError());
        }

        // $postData = $v->all(); // 原始数据
        $safeData = $v->getSafeData(); // 验证通过的安全数据

        return apiResponse($safeData);
    }
```
