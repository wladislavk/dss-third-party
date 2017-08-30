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
        $this->assertResponseOk();
        $this
            ->seeHeader(CorsMiddleware::ALLOW_ORIGIN_HEADER, $hostname)
            ->seeHeader(CorsMiddleware::ALLOW_METHODS_HEADER, CorsMiddleware::ALLOWED_METHODS)
            ->seeHeader(CorsMiddleware::ALLOW_HEADERS_HEADER, CorsMiddleware::ALLOWED_HEADERS)
        ;
    }
}
