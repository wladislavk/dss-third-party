<?php

namespace Tests\Api;

use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Eloquent\Models\Admin;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Http\Middleware\JwtAdminAuthMiddleware;
use DentalSleepSolutions\Http\Middleware\JwtUserAuthMiddleware;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Facades\ApiResponse;
use Tests\TestCases\JwtAuthMiddlewareTestCase;

class JwtSudoAuthMiddlewareTest extends JwtAuthMiddlewareTestCase
{
    protected $testMiddleware = [
        JwtAdminAuthMiddleware::class,
        JwtUserAuthMiddleware::class,
    ];

    public function testSudoNoId()
    {
        $admin = factory(Admin::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_ADMIN, $admin->adminid);
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseOk();
        $this
            ->seeJson([
                'username' => $admin->username
            ])
        ;
    }

    public function testSudoNoUser()
    {
        $admin = factory(Admin::class)->create();
        $user = factory(User::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_ADMIN, $admin->adminid);
        $sudoQuery = $this->generateSudoUserQuery($user);
        $user->delete();

        $this->get(self::TEST_ROUTE . '?' . $sudoQuery, $authHeader);

        $this->assertResponseOk();
        $this
            ->seeJson([
                'username' => $admin->username
            ])
            ->dontSeeJson([
                'username' => $user->username
            ])
        ;
    }

    public function testSudoLoggedIn()
    {
        $admin = factory(Admin::class)->create();
        $user = factory(User::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_ADMIN, $admin->adminid);
        $sudoQuery = $this->generateSudoUserQuery($user);

        $this->get(self::TEST_ROUTE . '?' . $sudoQuery, $authHeader);

        $this->assertResponseOk();
        $this
            ->seeJson([
                'username' => $admin->username
            ])
            ->seeJson([
                'username' => $user->username
            ])
        ;
    }

    protected function requestHandler(Request $request)
    {
        return ApiResponse::responseOk('', [
            $request->admin(),
            $request->user(),
        ]);
    }
}
