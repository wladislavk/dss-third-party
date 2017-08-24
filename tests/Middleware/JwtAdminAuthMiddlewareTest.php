<?php
namespace Tests\Api;

use Carbon\Carbon;
use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Eloquent\Models\Admin;
use DentalSleepSolutions\Helpers\JwtHelper;
use DentalSleepSolutions\Http\Middleware\JwtAdminAuthMiddleware;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Tests\TestCases\MiddlewareTestCase;

class JwtAdminAuthMiddlewareTest extends MiddlewareTestCase
{
    const MINIMAL_TTl = 1;
    const TTL = 60;
    const ADMIN_PREFIX = 'a_';

    protected $testMiddleware = [
        JwtAdminAuthMiddleware::class
    ];

    /** @var Admin */
    private $admin;

    /** @var JwtHelper */
    private $jwtHelper;

    public function setUp()
    {
        parent::setUp();
        $this->admin = factory(Admin::class)->create();
        $this->jwtHelper = $this->app
            ->make(JwtHelper::class)
        ;
    }

    public function testNoToken()
    {
        $this->get(self::TEST_ROUTE);

        $this->seeJson([
            'data' => null
        ])
            ->assertResponseOk()
        ;
    }

    public function testInactiveToken()
    {
        $token = $this->generateToken('inactive');
        $this->get(self::TEST_ROUTE, [
            JwtAdminAuthMiddleware::AUTH_HEADER => JwtAdminAuthMiddleware::AUTH_HEADER_START . $token
        ]);

        $this->seeJson([
            'data' => null
        ])
            ->assertResponseOk()
        ;
    }

    public function testExpiredToken()
    {
        $token = $this->generateToken('expired');
        $this->get(self::TEST_ROUTE, [
            JwtAdminAuthMiddleware::AUTH_HEADER => JwtAdminAuthMiddleware::AUTH_HEADER_START . $token
        ]);

        $this->seeJson([
            'data' => null
        ])
            ->assertResponseOk()
        ;
    }

    public function testUserNotFound()
    {
        $token = $this->generateToken();
        $this->admin->delete();

        $this->get(self::TEST_ROUTE, [
            JwtAdminAuthMiddleware::AUTH_HEADER => JwtAdminAuthMiddleware::AUTH_HEADER_START . $token
        ]);

        $this->seeJson([
            'data' => null
        ])
            ->assertResponseOk()
        ;
    }

    public function testLoggedIn()
    {
        $token = $this->generateToken();

        $this->get(self::TEST_ROUTE, [
            JwtAdminAuthMiddleware::AUTH_HEADER => JwtAdminAuthMiddleware::AUTH_HEADER_START . $token
        ]);

        $this->seeJson([
            'username' => $this->admin->username
        ])
            ->assertResponseOk()
        ;
    }

    protected function requestHandler(Request $request)
    {
        return ApiResponse::responseOk('', $request->admin());
    }

    private function generateToken($state = '')
    {
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

        $token = $this->jwtHelper
            ->createToken([
                JwtAuth::CLAIM_ROLE_INDEX => JwtAuth::ROLE_ADMIN,
                JwtAuth::CLAIM_ID_INDEX => self::ADMIN_PREFIX . $this->admin->adminid,
            ], $expiresAt, $notBefore)
        ;

        if ($state === 'expired') {
            sleep(self::MINIMAL_TTl + 1);
        }

        return $token;
    }
}
