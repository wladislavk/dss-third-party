<?php
namespace Tests\Api;

use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Http\Middleware\JwtUserAuthMiddleware;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Structs\JwtMiddlewareErrors;
use Illuminate\Http\Response;
use Tests\TestCases\JwtAuthMiddlewateTestCase;

class JwtUserAuthMiddlewareTest extends JwtAuthMiddlewateTestCase
{
    protected $testMiddleware = [
        JwtUserAuthMiddleware::class
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
        $user = factory(User::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_USER, $user->userid, 'invalidToken');
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
        $this->seeJson([
            'message' => JwtMiddlewareErrors::TOKEN_INVALID
        ]);
    }

    public function testInactiveToken()
    {
        $user = factory(User::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_USER, $user->userid, 'inactive');
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJson([
            'message' => JwtMiddlewareErrors::TOKEN_INACTIVE
        ]);
    }

    public function testExpiredToken()
    {
        $user = factory(User::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_USER, $user->userid, 'expired');
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJson([
            'message' => JwtMiddlewareErrors::TOKEN_EXPIRED
        ]);
    }

    public function testInvalidPayload()
    {
        $user = factory(User::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_USER, $user->userid, 'invalidPayload');
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJson([
            'message' => JwtMiddlewareErrors::TOKEN_INVALID
        ]);
    }

    public function testUserNotFound()
    {
        $user = factory(User::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_USER, $user->userid);
        $user->delete();
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJson([
            'message' => JwtMiddlewareErrors::USER_NOT_FOUND
        ]);
    }

    public function testLoggedIn()
    {
        $user = factory(User::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_USER, $user->userid);
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseOk();
        $this->seeJson([
            'username' => $user->username
        ]);
    }

    protected function requestHandler(Request $request)
    {
        return ApiResponse::responseOk('', $request->user());
    }
}
