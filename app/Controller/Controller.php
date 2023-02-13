<?php declare(strict_types=1);
/**
 * The file is part of Dcr/framework
 *
 *
 */

namespace App\Controller;

use App\Middleware\Contract\MiddlewareInterface;
use App\Middleware\Kernel;
use App\Model\UserModel;
use App\Traits\BaseRequest;
use App\Utils\Config;
use App\Utils\Enviroment;
use App\Utils\JwtToken;
use App\Utils\Log;
use App\Utils\Redis;
use Dcr\Request as DcrRequest;
use Dcr\Request\Request;
use Dcr\Response\Response;
use DI\Attribute\Inject;
use Middlewares\Utils\Dispatcher;
use Exception;

class Controller
{
    use BaseRequest;

    public static false|string $className = '';

    public static null|array|string $user   = []; // 用户token信息

    public static array             $params = [];

    #[Inject]
    public DcrRequest $request;

    #[Inject]
    public Response $response;

    #[Inject]
    public Config $config;

    #[Inject]
    public \GuzzleHttp\Client $guzzleClient;

    public $redis;

    #[Inject]
    public Log $logger;

    public function __construct()
    {
//        $this->request = Request::instance();
//        $this->response     = di()->get(Response::class);
//        $this->logger       = di()->get(Log::class);
//        $this->config       = di()->get(Config::class);
//        $this->guzzleClient = di()->get(\GuzzleHttp\Client::class);
        $this->redis        = Redis::connection();

        self::$params    = Request::instance()->get() + Request::instance()->post();
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
    public function middleware($middleware): void
    {
        $middlewares = Kernel::getMiddlewares();
        $arr         = [];

        foreach ((array) $middleware as $m) {
            /** @var MiddlewareInterface $obj */
            $class = $middlewares[$m];
            $obj   = (new $class);
            $arr[] = $obj->handle();
        }
        try {
            Dispatcher::run($arr + [
                    function ($request, $next) {
                        //                echo 'from middleware';die;
                        $response = $next->handle($request);
                        return $response;
                    },
                ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    // 初始化
    protected function init(): bool
    {
        $token = $_GET['token'] ?? '';
        if ($token) {
            $user_arr = di()->get(JwtToken::class)->decode($token);
            if (isset($user_arr['id'])) {
                $this->uid = $user_arr['id'];
            }
        }
        if (Enviroment::isRoyeeDev()) {
            // self::$user['id'] = 11211;
            self::$user['id'] = 11211;
        }
        return true;
    }

    public function checkLogin(): bool|string
    {
        if (Enviroment::isRoyeeDev()) {
            //self::$user['id'] = 11211;
            self::$user['id'] = 160709;
            return true;
        }

        if (!isset(self::$user['id'])) {
            return error('您还未登录，请先登录');
        }
        return true;
    }

    public function getUserId()
    {
        return self::$user['id'] ?? 0;
    }

    public function getUser(): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return UserModel::query()->find($this->getUserId());
    }

    public function debugSql(): void
    {
        echo UserModel::getLastSql();
        return;
    }
}
