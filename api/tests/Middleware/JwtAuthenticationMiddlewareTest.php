<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Admin;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Http\Middleware\JwtAuthenticationMiddleware;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Services\Auth\JwtHelper;
use DentalSleepSolutions\Structs\JwtMiddlewareErrors;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Tests\TestCases\JwtAuthenticationMiddlewareTestCase;

class JwtAuthenticationMiddlewareTest extends JwtAuthenticationMiddlewareTestCase
{
    protected $testMiddleware = [
        JwtAuthenticationMiddleware::class,
    ];

    public function testMissingToken()
    {
        $this->get(self::TEST_ROUTE);
        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
        $this->seeJson([
            'errorMessage' => JwtMiddlewareErrors::TOKEN_MISSING,
        ]);
    }

    public function testExpiredToken()
    {
        $admin = factory(Admin::class)->create();
        $authHeader = $this->generateAuthHeader(JwtHelper::ROLE_ADMIN, $admin->adminid, 'expired');
        $this->get(self::TEST_ROUTE, $authHeader);
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJson([
            'errorMessage' => JwtMiddlewareErrors::TOKEN_EXPIRED,
        ]);
    }

    public function testInactiveToken()
    {
        $admin = factory(Admin::class)->create();
        $authHeader = $this->generateAuthHeader(JwtHelper::ROLE_ADMIN, $admin->adminid, 'inactive');
        $this->get(self::TEST_ROUTE, $authHeader);
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJson([
            'errorMessage' => JwtMiddlewareErrors::TOKEN_INACTIVE,
        ]);
    }

    public function testInvalidToken()
    {
        $admin = factory(Admin::class)->create();
        $authHeader = $this->generateAuthHeader(JwtHelper::ROLE_ADMIN, $admin->adminid, 'invalidToken');
        $this->get(self::TEST_ROUTE, $authHeader);
        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
        $this->seeJson([
            'errorMessage' => JwtMiddlewareErrors::TOKEN_INVALID,
        ]);
    }

    public function testInvalidPayload()
    {
        $admin = factory(Admin::class)->create();
        $authHeader = $this->generateAuthHeader(JwtHelper::ROLE_ADMIN, $admin->adminid, 'invalidPayload');
        $this->get(self::TEST_ROUTE, $authHeader);
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJson([
            'errorMessage' => JwtMiddlewareErrors::TOKEN_INVALID,
        ]);
    }

    public function testAdminToken()
    {
        $admin = factory(Admin::class)->create();
        $authHeader = $this->generateAuthHeader(JwtHelper::ROLE_ADMIN, $admin->adminid);
        $this->get(self::TEST_ROUTE, $authHeader);
        $this->assertResponseOk();
        $this->seeJson([
            'username' => $admin->username,
            'user' => null,
            'patient' => null,
        ]);
    }

    public function testUserToken()
    {
        $user = factory(User::class)->create();
        $authHeader = $this->generateAuthHeader(JwtHelper::ROLE_USER, $user->userid);
        $this->get(self::TEST_ROUTE, $authHeader);
        $this->assertResponseOk();
        $this->seeJson([
            'admin' => null,
            'username' => $user->username,
            'patient' => null,
        ]);
    }

    public function testPatientToken()
    {
        $patient = factory(Patient::class)->create();
        $authHeader = $this->generateAuthHeader(JwtHelper::ROLE_PATIENT, $patient->patientid);
        $this->get(self::TEST_ROUTE, $authHeader);
        $this->assertResponseOk();
        $this->seeJson([
            'admin' => null,
            'user' => null,
            'email' => $patient->email,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    protected function requestHandler(Request $request): JsonResponse
    {
        /** @var \Illuminate\Contracts\Auth\Factory $auth */
        $auth = $this->app['auth'];
        return ApiResponse::responseOk('', [
            'admin' => $auth->guard(JwtHelper::ROLE_ADMIN)->user(),
            'user' => $auth->guard(JwtHelper::ROLE_USER)->user(),
            'patient' => $auth->guard(JwtHelper::ROLE_PATIENT)->user(),
        ]);
    }
}
