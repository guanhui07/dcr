<?php

require __DIR__.'/../vendor/autoload.php';

use app\Utils\Json;
use dcr\Boostrap;
use dcr\Container;
use dcr\HttpKernel;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
define('PROJECT_ROOT', dirname(__DIR__).'/');

$container = Container::instance();

// 初始化 注册 config env  db orm  facade门面
/** @var Boostrap $bootstrap */
$bootstrap = $container->make(Boostrap::class);
$bootstrap->run();


// http路由
/** @var HttpKernel $httpKernel */
$httpKernel = $container->make(HttpKernel::class);
$responseStr = $httpKernel->run($container);
$responseStr = is_array($responseStr) ? Json::encode($responseStr) : $responseStr;
if ($responseStr instanceof SymfonyResponse) {
    return $responseStr;
}

// response
$response = dcr\Response\Response::instance();
$response->setContent($responseStr);
$response->send();




