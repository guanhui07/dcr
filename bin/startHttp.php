<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Adapterman\Adapterman;
use dcr\Boostrap;
use dcr\Container;
use dcr\HttpKernel;
use Workerman\Worker;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

define('PROJECT_ROOT', dirname(__DIR__).'/');

/**
 * @see https://github.com/guanhui07/blog/issues/818
 */

global $container;
$container = Container::instance();
function init()
{
    global $container;
    // 初始化 注册 config env  db orm  facade门面
    //(new Boostrap())->run();
    /** @var Boostrap $bootstrap */
    $bootstrap = $container->make(Boostrap::class);
    $bootstrap->run();

}


$http_worker                = new Worker('http://0.0.0.0:8001');
$http_worker->count         = 8;
$http_worker->name          = 'AdapterMan';

$http_worker->onWorkerStart = static function () {
    init();
};
Adapterman::init();

function run(): string
{
    ob_start();
    global $container;
    $responseStr = $container->make(HttpKernel::class)->run($container);
    $response = dcr\Response\Response::instance();
    $responseStr = is_array($responseStr) ? json_encode($responseStr) : $responseStr;
    if ($responseStr instanceof SymfonyResponse) {
        return $responseStr;
    }

    $response->setContent($responseStr);
    $response->send();
    return ob_get_clean();
}


$http_worker->onMessage = static function ($connection, $request) {
    $connection->send(run());
};

Worker::runAll();