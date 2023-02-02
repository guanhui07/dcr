<?php

namespace app\Controller;

use app\Middleware\Contract\MiddlewareInterface;
use app\Middleware\Kernel;
use app\Model\UserModel;
use app\Traits\BaseRequest;
use app\Utils\Enviroment;
use app\Utils\Redis;
use dcr\Request\Request;
use Middlewares\Utils\Dispatcher;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Controller
{
    use BaseRequest;

    public static false|string $className = '';

    public static null|array|string $user   = []; // 用户token信息
    public static array             $params = [];

    /**
     *
     */
    public $request;

    public function __construct()
    {
        $this->request   = Request::instance();
        self::$params    = $this->request->get() + $this->request->post() ;
        self::$className = get_called_class();
        if (isset(self::$params['token']) && Redis::connection()->get(stripslashes(self::$params['token']))) {
            self::$user = Redis::connection()->get(stripslashes(self::$params['token']));
        }
        $this->init();
    }

    /**
     * @param $middleware
     *
     * @see https://github.com/middlewares/utils
     */
    public function middleware($middleware)
    {
        $middlewares = Kernel::getMiddlewares();
        $arr         = [];

        foreach ((array) $middleware as $m) {
            /** @var MiddlewareInterface $obj */
            $class = $middlewares[$m];
            $obj   = (new $class);
            $arr[] = $obj->handle();
        }
        try{
            Dispatcher::run($arr + [
                    function ($request, $next) {
                        //                echo 'from middleware';die;
                        $response = $next->handle($request);
                        return $response;
                    },
                ]);
        }catch(\Exception $e){
            throw $e;
        }


    }

    // 初始化
    protected function init()
    {
        if (Enviroment::isRoyeeDev()) {
            // self::$user['id'] = 11211;
            self::$user['id'] = 11211;
        }
        return true;
    }

    public function checkLogin()
    {
        if (Enviroment::isRoyeeDev()) {
            //self::$user['id'] = 11211;
            self::$user['id'] = 160709;
            return true;
        }

        if ( !isset(self::$user['id'])) {
            return error('您还未登录，请先登录');
        }
        return true;
    }

    public function getUserId()
    {
        return self::$user['id'] ?? 0;
    }

    public function getUser()
    {
        return UserModel::query()->find($this->getUserId());
    }

}







