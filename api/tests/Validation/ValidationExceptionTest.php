<?php
namespace Tests\Validation;

use Illuminate\Http\Response;
use Tests\TestCases\BaseApiTestCase;

class ValidationExceptionTest extends BaseApiTestCase
{
    public function testValidationException()
    {
        $this->post(self::ROUTE_PREFIX . '/validation-exception');
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $expected = [
            'errors' => [
                'amount' => ['The amount field is required.'],
            ],
            'message' => 'The given data was invalid.',
        ];
        $this->seeJson($expected);
    }
}
