<?php
namespace Tests\Api;

use DentalSleepSolutions\Http\Middleware\CorsMiddleware;
use Tests\TestCases\MiddlewareTestCase;

class CorsMiddlewareTest extends MiddlewareTestCase
{
    protected $testMiddleware = [
        CorsMiddleware::class
    ];

    public function testHandle()
    {
        $this->get(self::TEST_ROUTE);

        $hostname = parse_url($this->baseUrl, PHP_URL_HOST);
        $this
            ->seeHeader('Access-Control-Allow-Origin', $hostname)
            ->seeHeader('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
            ->seeHeader('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization')
            ->assertResponseOk()
        ;
    }
}
