<?php
declare(strict_types = 1);

namespace dcr;

use app\Utils\Json;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

/**
 * Http路由
 * Class HttpKernel
 */
class HttpKernel
{
    /**
     * @param $container \DI\Container
     *
     * @return mixed
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function run($container): mixed
    {
        $r      = request()->get('r', null);
        $router = $r !== null ? strtolower($r) : '';

        if ($router) {
            $ret = $this->defaultRoute($router, $container);

            if ($ret === false) {
                $ret = $this->restfulRoute($container);
            }
        } else {
            $ret = $this->restfulRoute($container);
        }
        return $ret;
    }

    /**
     * 不推荐使用此默认路由方法 (类似Yii框架 ?r=home/index )
     *
     * @param  string  $router
     * @param  \DI\Container  $container
     *
     * @return array|bool|int|string
     * @throws DependencyException
     * @throws NotFoundException
     */
    protected function defaultRoute(string $router, \DI\Container $container): array|bool|int|string
    {
        $routerArr = explode('/', $router);
        if (count($routerArr) !== 2) {
            return false;
        }

        $controller = ucfirst(array_shift($routerArr)).'Controller';
        $action     = array_pop($routerArr);
        $class_name = 'app\\controller\\'.$controller;
        if ( !file_exists(PROJECT_ROOT.'./app/controller/'.$controller.'.php') || !class_exists($class_name)) {
            return false;
        }

        try{
            //    $o = new $class_name();

            // 实例化器能够创建任何类的新实例，而无需使用类本身的构造函数或任何 API：
            //    $instantiator = new \Doctrine\Instantiator\Instantiator();
            //    $o = $instantiator->instantiate($class_name);
            $o = $container->get($class_name);

            if (method_exists($o, $action)) {
                $temp = $o->$action();
                if (is_array($temp)) {
                    return Json::encode($temp);
                }

                if (is_string($temp) || is_int($temp)) {
                    return $temp;
                }
            } else {
                return (Json::encode(['status' => 10010, 'msg' => 'action error']));
            }
        }catch (Exception $e) {
            return $e->getMessage();
        }

        return $routerArr;
    }

    /**
     * restful方式 ，路由配置 写在 routes目录
     *
     * @param $container
     *
     * @return false|mixed|string
     * @see https://github.com/nikic/FastRoute
     */
    protected function restfulRoute($container)
    {
        $routes = require(PROJECT_ROOT.'routes/api.php');

        $routeCollectorGenerator = function (RouteCollector $r) use ($routes) {
            foreach ($routes as $route) {
                $r->addRoute($route[0], $route[1], $route[2]);
            }
        };

        // 获取http请求方式和资源URI
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        // 将url中的get传参方式（?foo=bar）剥离并对URI进行解析
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $dispatcher = simpleDispatcher($routeCollectorGenerator);
        $routeInfo  = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $uri);

        // 根据调度器进行匹配
        switch ($routeInfo[0]) {
            // 使用未定义路由格式
            case Dispatcher::NOT_FOUND:
                return (Json::encode(['status' => 10010, 'msg' => 'route not found']));
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                return (Json::encode(['status' => 10010, 'msg' => 'route method not allow,'.$allowedMethods.' method is allow']));
            // 调用$handler和$vars*
            case Dispatcher::FOUND:
                try{
                    if (is_object($routeInfo[1])) {
                        $handler = $routeInfo[1];
                        $str     = $handler();
                        return $str;
                    }

                    //                $controller = new $routeInfo[1][0];
                    //                $instantiator = new \Doctrine\Instantiator\Instantiator();
                    //                $controller = $instantiator->instantiate($routeInfo[1][0]);
                    $method = $routeInfo[1][1];
                    //                $controller->$method();
                    $str = $container->get($routeInfo[1][0])->$method();
                    return $str;
                }catch(Exception $e){
                    return $e->getMessage();
                }

        }
        return '';
    }
}