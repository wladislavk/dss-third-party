<?php
namespace Tests\Api;

use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Eloquent\Models\Admin;
use DentalSleepSolutions\Http\Middleware\JwtAdminAuthMiddleware;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Facades\ApiResponse;
use Tests\TestCases\JwtAuthMiddlewateTestCase;

class JwtAdminAuthMiddlewareTest extends JwtAuthMiddlewateTestCase
{
    protected $testMiddleware = [
        JwtAdminAuthMiddleware::class
    ];

    public function testNoToken()
    {
        $this->get(self::TEST_ROUTE);

        $this->assertResponseOk();
        $this->seeJson([
            'data' => null
        ]);
    }

    public function testInactiveToken()
    {
        $admin = factory(Admin::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_ADMIN, $admin->adminid, 'inactive');
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseOk();
        $this->seeJson([
            'data' => null
        ]);
    }

    public function testExpiredToken()
    {
        $admin = factory(Admin::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_ADMIN, $admin->adminid, 'expired');
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseOk();
        $this->seeJson([
            'data' => null
        ]);
    }

    public function testUserNotFound()
    {
        $admin = factory(Admin::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_ADMIN, $admin->adminid);
        $admin->delete();

        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseOk();
        $this->seeJson([
            'data' => null
        ]);
    }

    public function testLoggedIn()
    {
        $admin = factory(Admin::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_ADMIN, $admin->adminid);
        $this->get(self::TEST_ROUTE, $authHeader);

        $this->assertResponseOk();
        $this->seeJson([
            'username' => $admin->username
        ]);
    }

    protected function requestHandler(Request $request)
    {
        return ApiResponse::responseOk('', $request->admin());
    }
}
