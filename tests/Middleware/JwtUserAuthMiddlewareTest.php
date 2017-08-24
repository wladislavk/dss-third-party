<?php
namespace Tests\Api;

use Carbon\Carbon;
use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Helpers\JwtHelper;
use DentalSleepSolutions\Http\Middleware\JwtUserAuthMiddleware;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Structs\JwtMiddlewareErrors;
use Illuminate\Http\Response;
use Tests\TestCases\MiddlewareTestCase;

class JwtUserAuthMiddlewareTest extends MiddlewareTestCase
{
    const MINIMAL_TTl = 1;
    const TTL = 60;
    const USER_PREFIX = 'u_';

    protected $testMiddleware = [
        JwtUserAuthMiddleware::class
    ];

    /** @var User */
    private $user;

    /** @var JwtHelper */
    private $jwtHelper;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->jwtHelper = $this->app
            ->make(JwtHelper::class)
        ;
    }

    public function testNoToken()
    {
        $this->get(self::TEST_ROUTE);

        $this->seeJson([
            'message' => JwtMiddlewareErrors::TOKEN_INVALID
        ])
            ->assertResponseStatus(Response::HTTP_BAD_REQUEST)
        ;
    }

    public function testInvalidToken()
    {
        $token = $this->generateToken('invalidToken');
        $this->get(self::TEST_ROUTE, [
            JwtUserAuthMiddleware::AUTH_HEADER => JwtUserAuthMiddleware::AUTH_HEADER_START . $token
        ]);

        $this->seeJson([
            'message' => JwtMiddlewareErrors::TOKEN_INVALID
        ])
            ->assertResponseStatus(Response::HTTP_BAD_REQUEST)
        ;
    }

    public function testInactiveToken()
    {
        $token = $this->generateToken('inactive');
        $this->get(self::TEST_ROUTE, [
            JwtUserAuthMiddleware::AUTH_HEADER => JwtUserAuthMiddleware::AUTH_HEADER_START . $token
        ]);

        $this->seeJson([
            'message' => JwtMiddlewareErrors::TOKEN_INACTIVE
        ])
            ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ;
    }

    public function testExpiredToken()
    {
        $token = $this->generateToken('expired');
        $this->get(self::TEST_ROUTE, [
            JwtUserAuthMiddleware::AUTH_HEADER => JwtUserAuthMiddleware::AUTH_HEADER_START . $token
        ]);

        $this->seeJson([
            'message' => JwtMiddlewareErrors::TOKEN_EXPIRED
        ])
            ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ;
    }

    public function testInvalidPayload()
    {
        $token = $this->generateToken('invalidPayload');
        $this->get(self::TEST_ROUTE, [
            JwtUserAuthMiddleware::AUTH_HEADER => JwtUserAuthMiddleware::AUTH_HEADER_START . $token
        ]);

        $this->seeJson([
            'message' => JwtMiddlewareErrors::TOKEN_INVALID
        ])
            ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ;
    }

    public function testUserNotFound()
    {
        $token = $this->generateToken();
        $this->user->delete();

        $this->get(self::TEST_ROUTE, [
            JwtUserAuthMiddleware::AUTH_HEADER => JwtUserAuthMiddleware::AUTH_HEADER_START . $token
        ]);

        $this->seeJson([
            'message' => JwtMiddlewareErrors::USER_NOT_FOUND
        ])
            ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ;
    }

    public function testLoggedIn()
    {
        $token = $this->generateToken();

        $this->get(self::TEST_ROUTE, [
            JwtUserAuthMiddleware::AUTH_HEADER => JwtUserAuthMiddleware::AUTH_HEADER_START . $token
        ]);

        $this->seeJson([
            'username' => $this->user->username
        ])
            ->assertResponseOk()
        ;
    }

    protected function requestHandler(Request $request)
    {
        return ApiResponse::responseOk('', $request->user());
    }

    private function generateToken($state = '')
    {
        $claims = [
            JwtAuth::CLAIM_ROLE_INDEX => JwtAuth::ROLE_USER,
            JwtAuth::CLAIM_ID_INDEX => self::USER_PREFIX . $this->user->userid,
        ];
        $expiresAt = Carbon::now()->addSeconds(self::TTL);
        $notBefore = null;

        if ($state === 'expired') {
            $expiresAt = Carbon::now()
                ->addSeconds(self::MINIMAL_TTl)
            ;
        }

        if ($state === 'inactive') {
            $expiresAt = Carbon::now()
                ->addSeconds(self::TTL)
            ;
            $notBefore = Carbon::now()
                ->addSeconds(self::TTL)
            ;
        }

        if ($state === 'invalidToken') {
            $claims['iss'] = 'Test';
        }

        if ($state === 'invalidPayload') {
            unset($claims[JwtAuth::CLAIM_ID_INDEX]);
        }

        $token = $this->jwtHelper
            ->createToken($claims, $expiresAt, $notBefore)
        ;

        if ($state === 'expired') {
            sleep(self::MINIMAL_TTl + 1);
        }

        return $token;
    }
}
