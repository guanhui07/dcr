<?php declare(strict_types=1);
/**
 * The file is part of xxx/xxx
 *
 *
 */

namespace app\Controller;

use app\Middleware\AuthMiddleware;
use app\Middleware\TestMiddleware;
use app\Service\TestService;
use dcr\Annotation\Mapping\Middlewares;
use dcr\Annotation\Mapping\RequestMapping;
use DI\Attribute\Inject;

class MIddlewareController extends Controller
{
    #[Inject]
    public TestService $testService;

    public function __construct()
    {
        parent::__construct();
    }

    #[RequestMapping(methods: 'GET , POST', path:'/test/middleware')]
    #[Middlewares(AuthMiddleware::class, TestMiddleware::class)]
    public function test1(): string
    {
//        $this->testService->testDi();
        return apiResponse([]);
    }
}
