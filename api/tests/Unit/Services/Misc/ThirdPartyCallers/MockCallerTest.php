<?php

namespace Tests\Unit\Services\Misc\ThirdPartyCallers;

use DentalSleepSolutions\Services\Misc\ThirdPartyCallers\MockCaller;
use Tests\TestCases\UnitTestCase;

class MockCallerTest extends UnitTestCase
{
    /** @var MockCaller */
    private $mockCaller;

    public function setUp()
    {
        $this->mockCaller = new MockCaller();
    }

    public function testCallApi()
    {
        $newResponse = json_encode(['foo' => 'bar']);
        $this->mockCaller->setExpectedResponse($newResponse);
        $method = 'GET';
        $path = '/path';
        $headers = ['name' => 'value'];
        $response = $this->mockCaller->callApi($method, $path, $headers);
        $this->assertEquals('{"foo":"bar"}', $response);
    }

    public function testWithoutPresetValue()
    {
        $method = 'GET';
        $path = '/path';
        $headers = ['name' => 'value'];
        $response = $this->mockCaller->callApi($method, $path, $headers);
        $this->assertEquals('{}', $response);
    }
}
