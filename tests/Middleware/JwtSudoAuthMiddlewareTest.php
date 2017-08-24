<?php

namespace Tests\Api;

use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Eloquent\Models\Admin;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Helpers\JwtHelper;
use DentalSleepSolutions\Http\Middleware\JwtAdminAuthMiddleware;
use DentalSleepSolutions\Http\Middleware\JwtUserAuthMiddleware;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Tests\TestCases\MiddlewareTestCase;

class JwtSudoAuthMiddlewareTest extends MiddlewareTestCase
{
    const MINIMAL_TTl = 1;
    const TTL = 60;
    const ADMIN_PREFIX = 'a_';
    const USER_PREFIX = 'u_';

    protected $testMiddleware = [
        JwtAdminAuthMiddleware::class,
        JwtUserAuthMiddleware::class,
    ];

    /** @var User */
    private $admin;

    /** @var User */
    private $user;

    /** @var JwtHelper */
    private $jwtHelper;

    public function setUp()
    {
        parent::setUp();
        $this->admin = factory(Admin::class)->create();
        $this->user = factory(User::class)->create();
        $this->jwtHelper = $this->app
            ->make(JwtHelper::class)
        ;
    }

    public function testSudoNoId()
    {
        $token = $this->generateToken();
        $this->get(self::TEST_ROUTE, [
            JwtUserAuthMiddleware::AUTH_HEADER => JwtUserAuthMiddleware::AUTH_HEADER_START . $token
        ]);

        $this->seeJson([
                'username' => $this->admin->username
            ])
            ->dontSeeJson([
                'username' => $this->user->username
            ])
            ->assertResponseOk()
        ;
    }

    public function testSudoNoUser()
    {
        $token = $this->generateToken();
        $sudoId = $this->user->{JwtUserAuthMiddleware::SUDO_REFERENCE};
        $this->user->delete();

        $this->post(self::TEST_ROUTE, [
            JwtUserAuthMiddleware::SUDO_FIELD => $sudoId
        ], [
            JwtUserAuthMiddleware::AUTH_HEADER => JwtUserAuthMiddleware::AUTH_HEADER_START . $token
        ]);

        $this->seeJson([
                'username' => $this->admin->username
            ])
            ->dontSeeJson([
                'username' => $this->user->username
            ])
            ->assertResponseOk()
        ;
    }

    public function testSudoLoggedIn()
    {
        $token = $this->generateToken();
        $sudoId = $this->user->{JwtUserAuthMiddleware::SUDO_REFERENCE};

        $this->post(self::TEST_ROUTE, [
            JwtUserAuthMiddleware::SUDO_FIELD => $sudoId
        ], [
            JwtUserAuthMiddleware::AUTH_HEADER => JwtUserAuthMiddleware::AUTH_HEADER_START . $token
        ]);

        $this->seeJson([
                'username' => $this->admin->username
            ])
            ->seeJson([
                'username' => $this->user->username
            ])
            ->assertResponseOk()
        ;
    }

    protected function requestHandler(Request $request)
    {
        return ApiResponse::responseOk('', [
            $request->admin(),
            $request->user(),
        ]);
    }

    private function generateToken()
    {
        $token = $this->jwtHelper
            ->createToken([
                JwtAuth::CLAIM_ROLE_INDEX => JwtAuth::ROLE_ADMIN,
                JwtAuth::CLAIM_ID_INDEX => self::ADMIN_PREFIX . $this->admin->adminid,
            ])
        ;
        return $token;
    }
}
