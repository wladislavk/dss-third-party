<?php
namespace Tests\Api;

use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Eloquent\Models\Admin;
use DentalSleepSolutions\Http\Middleware\JwtAdminAuthChainMiddleware;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Structs\JwtMiddlewareErrors;
use Illuminate\Http\Response;
use Tests\TestCases\JwtAuthMiddlewareTestCase;

class JwtAdminAuthChainMiddlewareTest extends JwtAuthMiddlewareTestCase
{
    protected $testMiddleware = [
        JwtAdminAuthChainMiddleware::class
    ];

    public function testNoToken()
    {
        $this->get(self::TEST_ROUTE);

        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
        $this->seeJson([
            'errorMessage' => JwtMiddlewareErrors::TOKEN_MISSING,
        ]);
    }

    public function testInactiveToken()
    {
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_ADMIN, 0, 'inactive');
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJson([
            'errorMessage' => JwtMiddlewareErrors::TOKEN_INACTIVE,
        ]);
    }

    public function testExpiredToken()
    {
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_ADMIN, 0, 'expired');
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJson([
            'errorMessage' => JwtMiddlewareErrors::TOKEN_EXPIRED,
        ]);
    }

    public function testInvalidPayload()
    {
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_USER, 0);
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseOk();
        $this->seeJson([
            'data' => null,
        ]);
    }

    public function testUserNotFound()
    {
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_ADMIN, 0);
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJson([
            'errorMessage' => JwtMiddlewareErrors::USER_NOT_FOUND,
        ]);
    }

    public function testLoggedIn()
    {
        $admin = factory(Admin::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_ADMIN, $admin->adminid);
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseOk();
        $this->seeJson([
            'username' => $admin->username,
        ]);
    }

    protected function requestHandler(Request $request)
    {
        return ApiResponse::responseOk('', $request->admin());
    }
}
