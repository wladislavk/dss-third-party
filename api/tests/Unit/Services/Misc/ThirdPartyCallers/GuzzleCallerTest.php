<?php

namespace Tests\Unit\Services\Misc\ThirdPartyCallers;

use DentalSleepSolutions\Services\Misc\ThirdPartyCallers\GuzzleCaller;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class GuzzleCallerTest extends UnitTestCase
{
    /** @var string */
    private $contents = '';

    /** @var array */
    private $arguments = [];

    /** @var GuzzleCaller */
    private $guzzleCaller;

    public function setUp()
    {
        $guzzleClient = $this->mockGuzzleClient();
        $this->guzzleCaller = new GuzzleCaller($guzzleClient);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testCallApi()
    {
        $method = 'GET';
        $path = '/path';
        $headers = ['name' => 'value'];
        $this->contents = 'foo';
        $response = $this->guzzleCaller->callApi($method, $path, $headers);
        $expectedArguments = [
            'method' => $method,
            'path' => $path,
            'headers' => $headers,
        ];
        $this->assertEquals($expectedArguments, $this->arguments);
        $this->assertEquals('foo', $response);
    }

    private function mockGuzzleClient()
    {
        /** @var Client|MockInterface $guzzleClient */
        $guzzleClient = \Mockery::mock(Client::class);
        $guzzleClient->shouldReceive('request')->once()->andReturnUsing(function ($method, $path, $headers) {
            $this->arguments = [
                'method' => $method,
                'path' => $path,
                'headers' => $headers,
            ];
            return $this->mockResponse();
        });
        return $guzzleClient;
    }

    private function mockStream()
    {
        /** @var Stream|MockInterface $stream */
        $stream = \Mockery::mock(Stream::class);
        $stream->shouldReceive('getContents')->once()->andReturnUsing(function () {
            return $this->contents;
        });
        // this line is needed to avoid bug in Mockery
        $stream->shouldReceive('close')->andReturnNull();
        return $stream;
    }

    private function mockResponse()
    {
        /** @var Response|MockInterface $response */
        $response = \Mockery::mock(Response::class);
        $response->shouldReceive('getBody')->once()->andReturn($this->mockStream());
        return $response;
    }
}
