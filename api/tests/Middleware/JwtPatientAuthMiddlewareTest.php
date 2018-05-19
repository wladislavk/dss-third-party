<?php
namespace Tests\Api;

use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Http\Middleware\JwtPatientAuthMiddleware;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Structs\JwtMiddlewareErrors;
use Illuminate\Http\Response;
use Tests\TestCases\JwtAuthMiddlewareTestCase;

class JwtPatientAuthMiddlewareTest extends JwtAuthMiddlewareTestCase
{
    protected $testMiddleware = [
        JwtPatientAuthMiddleware::class
    ];

    public function testNoToken()
    {
        $this->get(self::TEST_ROUTE);

        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
        $this->seeJson([
            'message' => JwtMiddlewareErrors::TOKEN_MISSING
        ]);
    }

    public function testInvalidToken()
    {
        $patient = factory(Patient::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_PATIENT, $patient->patientid, 'invalidToken');
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
        $this->seeJson([
            'message' => JwtMiddlewareErrors::TOKEN_INVALID
        ]);
    }

    public function testInactiveToken()
    {
        $patient = factory(Patient::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_PATIENT, $patient->patientid, 'inactive');
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJson([
            'message' => JwtMiddlewareErrors::TOKEN_INACTIVE
        ]);
    }

    public function testExpiredToken()
    {
        $patient = factory(Patient::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_PATIENT, $patient->patientid, 'expired');
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJson([
            'message' => JwtMiddlewareErrors::TOKEN_EXPIRED
        ]);
    }

    public function testInvalidPayload()
    {
        $patient = factory(Patient::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_PATIENT, $patient->patientid, 'invalidPayload');
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJson([
            'message' => JwtMiddlewareErrors::TOKEN_INVALID
        ]);
    }

    public function testUserNotFound()
    {
        $patient = factory(Patient::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_PATIENT, $patient->patientid);
        $patient->delete();
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJson([
            'message' => JwtMiddlewareErrors::USER_NOT_FOUND
        ]);
    }

    public function testLoggedIn()
    {
        $patient = factory(Patient::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_PATIENT, $patient->patientid);
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseOk();
        $this->seeJson([
            'email' => $patient->email
        ]);
    }

    protected function requestHandler(Request $request)
    {
        return ApiResponse::responseOk('', $request->patient());
    }
}
