<?php declare(strict_types=1);
/**
 * The file is part of xxx/xxx
 *
 *
 */

namespace app\Controller;

use app\Event\TestEvent;
use app\Middleware\TestMiddleware;
use app\Model\UserModel;
use app\Service\Entity\ExchGiftInfo;
use app\Service\Entity\TestEntity;
use app\Service\TestService;
use app\Utils\JwtToken;
use app\Utils\LogBase;
use Carbon\Carbon;
use dcr\Annotation\Mapping\RequestMapping;
use dcr\Facade\TestFacade;
use DI\Attribute\Inject;
use Exception;
use Gregwar\Captcha\CaptchaBuilder;
use GuzzleHttp\Client;
use Illuminate\Database\Capsule\Manager as DB;
use Inhere\Validate\Validation;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;

class TestController extends Controller
{
    /**
     * php8注解方式注入
     * @var TestService
     */
    #[Inject]
    public TestService $testService;

    /**
     * 测试构造参数依赖注入
     * 测试使用中间件
     *
     * @param  TestService  $s
     */
    public function __construct(TestService $s)
    {
        parent::__construct();
//        $this->testService = $s;
        $this->middleware(TestMiddleware::class);
    }

    /**
     * 测试 log carbon collect model redis 依赖注入
     * 测试 facade
     */
    #[RequestMapping(methods: 'GET , POST', path:'/test/test2')]
    public function test2()
    {
        // 测试 request
        $test = $this->request->get('name', 'zhangsan');

        //测试获取config
        //        var_dump( config('app.debug'));die;
        // 测试 response
        //        return  reponse()->setContent('test_abc')->send();
        // 测试collect
        $test = collect([23, 34])->pop(1);
        // 测试carbon
        echo Carbon::now()->format('Y-m-d');
        // 测试 log
        LogBase::info(2222);
        $this->logger->info(2222);
        // 测试 laravel orm包
        $allProject = DB::table('user')->where('id', '>', 1)
            ->orderBy('id', 'desc')->get();
        // 测试 laravel orm包
        $ret = UserModel::query()->limit(2)->get(['name', 'id', 'nickname']);

        //测试redis
        //        Redis::connection()->setex('test_key',22,45);
        //        debug(Redis::connection()->get('test_key'));

        // 测试 DI
        $this->testService->testDi();

        // 测试 门面
        TestFacade::testFacade();

        return apiResponse($ret);
    }

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

    /**
     * 测试Validate
     * @see https://github.com/inhere/php-validate
     */
    #[RequestMapping(methods: 'GET , POST', path:'/test/test4')]
    public function test4()
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

    /**
     * 测试事件
     * @see  https://github.com/inhere/php-event-manager
     */
    #[RequestMapping(methods: 'GET , POST', path:'/test/event')]
    public function event()
    {
        $test = request()->get('aa', 23);
        $test = $this->request->get('ab', 24);
        echo $test;
        $params = [
            'test' => 23,
        ];

        //        return  reponse()->setContent('abc')->send();

        event(TestEvent::preFoo, $params);
        return apiResponse([]);
    }

    /**
     * 测试 dto
     */
    #[RequestMapping(methods: 'GET , POST', path:'/test/dto')]
    public function dto()
    {
        arrayToEntity([
            'msg' => 'dsfdf',
            'user_id' => 222,

        ], new TestEntity());

        $settleConfig = new TestEntity([
            'msg' => 'dsfdf',
            'user_id' => 222,
            'gift' => new ExchGiftInfo([
                'id' => 1,
                'name' => 'test',
            ]),
        ]);
        return $this->dtoParam($settleConfig);
    }

    protected function dtoParam(TestEntity $testEntity)
    {
        return $testEntity->gift->id;
    }

    /**
     * 验证码
     * @see https://github.com/Gregwar/Captcha
     */
    public function captcha(): void
    {
        $builder = new CaptchaBuilder;
        $builder->build();
        //用户关联 存入redis 存活x秒
        //$builder->getPhrase();

        header('Content-type: image/jpeg');
        $builder->output();
    }

    /**
     * 缩略图
     * 上传七牛CDN
     * @see https://image.intervention.io/v2/usage/overview#basic-usage
     * 需要安装 https://pecl.php.net/package/imagick 扩展
     * @throws Exception
     */
    public function thump()
    {
        $manager = new ImageManager(['driver' => 'imagick']);
        $image = $manager->make('public/image/test.jpg')->resize(300, 200);
        Image::make('public/image/test.jpg')->resize(320, 240)->insert('public/image/watermark.png');
        return $this->uploadByQiniuGetUri($image);
    }

    #[RequestMapping(methods: 'GET , POST', path:'/test/token')]
    public function token()
    {
        $token = JwtToken::encode([
            'uid'=>27,
            'name'=>'test',
        ]);
//        dd($token);
//        $token = '1813bef4c03caef6ec45380a7246d110';
        $arr = JwtToken::decode($token);
        return apiResponse($arr);
    }
}
