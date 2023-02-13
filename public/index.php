<?php

require __DIR__.'/../vendor/autoload.php';

use App\Utils\Json;
use Dcr\Boostrap;
use Dcr\Container;
use Dcr\HttpKernel;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
define('PROJECT_ROOT', dirname(__DIR__).'/');
! defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1));
header('Content-type: text/html; charset=utf-8');

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
$response = Dcr\Response\Response::instance();
$response->setContent($responseStr);
$response->send();




