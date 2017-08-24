<?php
namespace Tests\TestCases;

use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Dummies\Http\NoMiddlewareKernel;

class MiddlewareTestCase extends ApiTestCase
{
    use DatabaseTransactions;

    const TEST_ROUTE = 'test-route';

    /** @var array */
    protected $testMiddleware = [];

    public function setUp()
    {
        parent::setUp();
        $this->app->singleton(Kernel::class, NoMiddlewareKernel::class);
        $this->setUpTestEndpoint();
    }

    protected function setUpTestEndpoint()
    {
        $this->app
            ->router
            ->any(self::TEST_ROUTE, [
                'middleware' => $this->testMiddleware,
                'uses' => function (Request $request) {
                    return $this->requestHandler($request);
                }
            ])
        ;
    }

    protected function requestHandler(Request $request)
    {
        return ApiResponse::responseOk();
    }
}
