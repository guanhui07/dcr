### guzzle client

本框架使用 `guanhui07/guzzle` composer包，基础于 `guzzle/guzzle` 实现 Guzzle HTTP 协程处理器 ,异步非阻塞型客户端


```php
   /**
     * 测试guzzle
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    #[RequestMapping(methods: 'GET , POST', path:'/test/test3')]
    public function test3()
    {
        $client   = new Client();
        $response = $client->request('GET', 'https://api.github.com/repos/guzzle/guzzle');

        //        echo $response->getStatusCode(); // 200
        //        echo $response->getHeaderLine('content-type'); // 'application/json; charset=utf8'
        return $response->getBody(); // '{"id": 1420053, "name": "guzzle", ...}'
    }
```


