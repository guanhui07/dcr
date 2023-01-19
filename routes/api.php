<?php
declare(strict_types = 1);

use app\Controller\TestController;
use app\Controller\MqController;

//@see https://packagist.org/packages/nikic/fast-route
//@see https://blog.doylee.cn/nikic-fast-route%E4%BD%BF%E7%94%A8%E5%B0%8F%E7%BB%93/



//\dcr\facade\Route::addRoute('abc',[HomeController::class,'test2']);
//Route::addRoute('abc',[HomeController::class,'test2']);
$routes = [
    [['GET', 'POST'], '/test', [TestController::class,'test2']],
    [['GET', 'POST'], '/test2', [TestController::class,'test2']],
    [['GET', 'POST'], '/mq/test1', [MqController::class,'test1']],
    [['GET', 'POST'], '/test1', function(){
        echo 'test';
    }],
];

return $routes;









