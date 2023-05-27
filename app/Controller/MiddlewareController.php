<?php
declare(strict_types=1);
/**
 * The file is part of Dcr/framework
 *
 *
 */

namespace App\Controller;

use App\Middleware\AuthMiddleware;
use App\Middleware\TestMiddleware;
use App\Service\TestService;
use Dcr\Annotation\Mapping\Middlewares;
use Dcr\Annotation\Mapping\RequestMapping;
use DI\Attribute\Inject;

class MiddlewareController extends Controller
{
    #[Inject]
    public TestService $testService;

    public function __construct()
    {
        parent::__construct();
    }

    #[RequestMapping(methods: 'GET , POST', path:'/test/middleware')]
    #[Middlewares(AuthMiddleware::class, TestMiddleware::class)]
    public function test(): string
    {
//        $this->testService->testDi();
        return apiResponse([]);
    }
}
