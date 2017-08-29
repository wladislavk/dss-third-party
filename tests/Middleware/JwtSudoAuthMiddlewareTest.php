<?php

namespace Tests\Api;

use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Eloquent\Models\Admin;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Http\Middleware\JwtAdminAuthMiddleware;
use DentalSleepSolutions\Http\Middleware\JwtUserAuthMiddleware;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Tests\TestCases\JwtAuthMiddlewateTestCase;

class JwtSudoAuthMiddlewareTest extends JwtAuthMiddlewateTestCase
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
        $sudoQuery = $this->generateSudoQuery($user->{JwtUserAuthMiddleware::SUDO_REFERENCE});
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
        $sudoQuery = $this->generateSudoQuery($user->{JwtUserAuthMiddleware::SUDO_REFERENCE});

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
