## cache

dcr暂时只支持redis做缓存


## 使用
```php
use app\Utils\Redis;



```

```php
    Redis::connection()->setex('test',60,'val');
    Redis::connection()->get('test');
```
操作和predis一致

