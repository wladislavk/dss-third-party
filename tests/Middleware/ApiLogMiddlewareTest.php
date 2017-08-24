<?php
namespace Tests\Api;

use DentalSleepSolutions\Http\Middleware\ApiLogMiddleware;
use Faker\Factory as Faker;
use Tests\TestCases\MiddlewareTestCase;

class ApiLogMiddlewareTest extends MiddlewareTestCase
{
    const DATA_KEY = 'key';

    protected $testMiddleware = [
        ApiLogMiddleware::class
    ];

    public function testHandle()
    {
        $testData = $this->dataFactory();
        $this->post(self::TEST_ROUTE, $testData);

        $this
            ->seeInDatabase('dental_api_logs', [
                'method' => 'post',
                'route' => self::TEST_ROUTE,
                'payload' => json_encode($testData),
            ])
            ->assertResponseOk()
        ;
    }

    private function dataFactory()
    {
        $faker = Faker::create();

        $data = [
            self::DATA_KEY => $faker->sha256,
        ];

        return $data;
    }
}
