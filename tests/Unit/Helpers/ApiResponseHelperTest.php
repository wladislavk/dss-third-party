<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Helpers\ApiResponseHelper;
use DentalSleepSolutions\Helpers\FractalDataRetriever;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class ApiResponseHelperTest extends UnitTestCase
{
    /** @var mixed */
    private $fractalData;

    /** @var ApiResponseHelper */
    private $apiResponseHelper;

    public function setUp()
    {
        $fractalDataRetriever = $this->mockFractalDataRetriever();
        $this->apiResponseHelper = new ApiResponseHelper($fractalDataRetriever);
    }

    public function testResponseOk()
    {
        $message = 'my message';
        $data = ['foo' => 'bar'];
        $response = $this->apiResponseHelper->responseOk($message, $data);
        $this->assertEquals(200, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        $expected = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'my message',
            'data' => ['foo' => 'bar'],
        ];
        $this->assertEquals($expected, $content);
    }

    public function testResponseError()
    {
        $message = 'my message';
        $response = $this->apiResponseHelper->responseError($message, 422);
        $this->assertEquals(422, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        $expected = [
            'status' => 'Unprocessable Entity',
            'code' => 422,
            'message' => 'my message',
            'data' => [
                'errorMessage' => 'my message',
                'errors' => [],
            ],
        ];
        $this->assertEquals($expected, $content);
    }

    public function testResponseErrorWithData()
    {
        $message = 'my message';
        $data = ['foo' => 'bar'];
        $response = $this->apiResponseHelper->responseError($message, 422, $data);
        $this->assertEquals(422, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        $expected = [
            'status' => 'Unprocessable Entity',
            'code' => 422,
            'message' => 'my message',
            'data' => ['foo' => 'bar'],
        ];
        $this->assertEquals($expected, $content);
    }

    public function testResponseWithSuccess()
    {
        $data = [
            'data' => ['foo' => 'bar'],
            'success' => 1,
        ];
        $messageSuccess = 'success';
        $messageError = 'error';
        $response = $this->apiResponseHelper->response($data, $messageSuccess, $messageError);
        $this->assertEquals(200, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        $expected = [
            'status' => 'OK',
            'code' => 200,
            'message' => 'success',
            'data' => ['foo' => 'bar'],
        ];
        $this->assertEquals($expected, $content);
    }

    public function testResponseWithError()
    {
        $data = [
            'data' => ['foo' => 'bar'],
            'status' => 422,
        ];
        $messageSuccess = 'success';
        $messageError = 'error';
        $response = $this->apiResponseHelper->response($data, $messageSuccess, $messageError);
        $this->assertEquals(422, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        $expected = [
            'status' => 'Unprocessable Entity',
            'code' => 422,
            'message' => 'error',
            'data' => ['foo' => 'bar'],
        ];
        $this->assertEquals($expected, $content);
    }

    public function testResponseWithoutData()
    {
        $data = [];
        $messageSuccess = 'success';
        $messageError = 'error';
        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage('Data array must contain key \'data\'');
        $this->apiResponseHelper->response($data, $messageSuccess, $messageError);
    }

    public function testResponseWithoutStatus()
    {
        $data = [
            'data' => ['foo' => 'bar'],
        ];
        $messageSuccess = 'success';
        $messageError = 'error';
        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage('Data array must contain key \'status\'');
        $this->apiResponseHelper->response($data, $messageSuccess, $messageError);
    }

    public function testGetPaginateStructure()
    {
        $items = ['foo', 'bar'];
        $total = 30;
        $perPage = 10;
        $result = new LengthAwarePaginator($items, $total, $perPage);
        $result = $this->apiResponseHelper->getPaginateStructure($result);
        $expected = [
            'total' => 30,
            'per_page' => 10,
            'current_page' => 1,
            'last_page' => 3,
            'next_page_url' => '/?page=2',
            'prev_page_url' => null,
            'from' => 1,
            'to' => 2,
            'items' => ['foo', 'bar'],
        ];
        $this->assertEquals($expected, $result);
    }

    public function testTransform()
    {
        $data = 'foo';
        $result = $this->apiResponseHelper->transform($data);
        $this->assertEquals('foo', $result);
    }

    public function testTransformWithFractalData()
    {
        $data = 'foo';
        $this->fractalData = 'bar';
        $result = $this->apiResponseHelper->transform($data);
        $this->assertEquals('bar', $result);
    }

    private function mockFractalDataRetriever()
    {
        /** @var FractalDataRetriever|MockInterface $fractalDataRetriever */
        $fractalDataRetriever = \Mockery::mock(FractalDataRetriever::class);
        $fractalDataRetriever->shouldReceive('getFractalData')
            ->andReturnUsing(function () {
                return $this->fractalData;
            });
        return $fractalDataRetriever;
    }
}
