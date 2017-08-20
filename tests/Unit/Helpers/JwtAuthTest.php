<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Auth\UserGuard;
use DentalSleepSolutions\Auth\AdminGuard;
use DentalSleepSolutions\Helpers\JwtHelper;
use DentalSleepSolutions\Helpers\JwtAuth as Auth;
use DentalSleepSolutions\Http\Requests\Request;
use Tests\TestCases\UnitTestCase;

class JwtAuthTest extends UnitTestCase
{
    const USER_ID = 'u_1';
    const ADMIN_ID = 'a_1';
    const USER_CLAIMS = [
        'role' => 'User',
        'id' => self::USER_ID
    ];
    const ADMIN_CLAIMS = [
        'role' => 'Admin',
        'id' => self::ADMIN_ID
    ];
    const CLAIMS_NO_ROLE = [
        'id' => self::USER_ID
    ];
    const CLAIMS_MISMATCHED_ROLE = [
        'role' => 'Admin',
        'id' => self::USER_ID
    ];
    const CLAIMS_NO_ID = [
        'role' => 'User',
    ];

    /** @var UserGuard */
    private $userGuard;

    /** @var AdminGuard */
    private $adminGuard;

    /** @var JwtHelper */
    private $jwtHelper;

    /** @var Request */
    private $request;

    /** @var Auth */
    private $auth;

    public function setUp()
    {
        $this->userGuard = $this->mockUserGuard();
        $this->adminGuard = $this->mockAdminGuard();
        $this->jwtHelper = $this->mockJwtHelper();
        $this->request = $this->mockRequest();
        $this->auth = new Auth($this->userGuard, $this->adminGuard, $this->jwtHelper, $this->request);
    }

    public function testToAdmin()
    {
        $this->jwtHelper->shouldReceive('parseToken')
            ->once()
            ->andReturn(self::ADMIN_CLAIMS)
        ;
        $result = $this->auth->toAdmin();
        $this->assertEquals(self::ADMIN_ID, $result);
    }

    public function testToUser()
    {
        $this->jwtHelper->shouldReceive('parseToken')
            ->once()
            ->andReturn(self::USER_CLAIMS)
        ;
        $result = $this->auth->toUser();
        $this->assertEquals(self::USER_ID, $result);
    }

    public function testToToken()
    {
        $result = $this->auth->toToken('User');
        $this->assertEquals('User', $result);
    }

    public function testToTokenException()
    {
        /**
         * @expectedException \DentalSleepSolutions\Exceptions\Auth\AuthenticatableNotFoundException
         */
        $result = $this->auth->toToken('Undefined');
    }

    private function mockUserGuard()
    {
        $mock = \Mockery::mock(UserGuard::class);
        $mock->shouldReceive('once')
            ->atMost(1)
            ->andReturn(true)
        ;
        $mock->shouldReceive('user')
            ->atMost(1)
            ->andReturn(self::USER_ID)
        ;
        return $mock;
    }

    private function mockAdminGuard()
    {
        $mock = \Mockery::mock(AdminGuard::class);
        $mock->shouldReceive('once')
            ->atMost(1)
            ->andReturn(true)
        ;
        $mock->shouldReceive('user')
            ->atMost(1)
            ->andReturn(self::ADMIN_ID)
        ;
        return $mock;
    }

    private function mockJwtHelper()
    {
        $mock = \Mockery::mock(JwtHelper::class);
        $mock->shouldReceive('createToken')
            ->atMost(1)
            ->andReturnUsing(function (array $claims) {
                return $claims['role'];
            })
        ;
        $mock->shouldReceive('validateClaims')
            ->atMost(1)
        ;

        return $mock;
    }

    private function mockRequest()
    {
        $mock = \Mockery::mock(Request::class);
        $mock->shouldReceive('header')
            ->atMost(1)
            ->andReturn(true)
        ;

        return $mock;
    }
}
