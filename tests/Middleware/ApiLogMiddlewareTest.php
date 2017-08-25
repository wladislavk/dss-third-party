<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\ApiLog;
use DentalSleepSolutions\Http\Middleware\ApiLogMiddleware;
use Tests\TestCases\MiddlewareTestCase;

class ApiLogMiddlewareTest extends MiddlewareTestCase
{
    /** @var array */
    protected $testMiddleware = [
        ApiLogMiddleware::class
    ];

    public function testHandle()
    {
        $record = factory(ApiLog::class)->make([
            'route' => self::TEST_ROUTE
        ]);
        $payload = json_decode($record->payload, true);

        $this->call($record->method, $record->route, $payload);

        $this->assertResponseOk();
        $this->seeInDatabase($record->getTable(), $record->toArray());
    }
}
