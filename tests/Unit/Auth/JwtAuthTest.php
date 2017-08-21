<?php

namespace Tests\Unit\Auth;

use DentalSleepSolutions\Auth\JwtAuth as Auth;
use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Exceptions\Auth\AuthenticatableNotFoundException;
use DentalSleepSolutions\Helpers\JwtHelper;
use DentalSleepSolutions\Providers\Auth\AdminGuard;
use DentalSleepSolutions\Providers\Auth\UserGuard;
use Illuminate\Contracts\Auth\Authenticatable;
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
    const TOKEN = 'token';

    /** @var UserGuard */
    private $userGuard;

    /** @var AdminGuard */
    private $adminGuard;

    /** @var JwtHelper */
    private $jwtHelper;

    /** @var Auth */
    private $auth;

    public function setUp()
    {
        $this->userGuard = $this->mockUserGuard();
        $this->adminGuard = $this->mockAdminGuard();
        $this->jwtHelper = $this->mockJwtHelper();
        $this->auth = new Auth($this->userGuard, $this->adminGuard, $this->jwtHelper);
    }

    public function testToTokenNoUser()
    {
        $this->userGuard->shouldReceive('user')
            ->once()
            ->andReturn(false)
        ;

        $this->expectException(AuthenticatableNotFoundException::class);
        $this->auth->toToken('User');
    }

    public function testToToken()
    {
        $this->userGuard->shouldReceive('user')
            ->once()
            ->andReturnUsing(function () {
                $user = new User();
                $user->id = self::USER_ID;

                return $user;
            })
        ;

        $token = $this->auth->toToken('User');
        $this->assertEquals(self::TOKEN, $token);
    }

    public function testToRoleAdminNoUser()
    {
        $this->jwtHelper->shouldReceive('parseToken')
            ->once()
            ->andReturn(self::ADMIN_CLAIMS)
        ;
        $this->adminGuard->shouldReceive('once')
            ->once()
            ->with([
                'id' => self::ADMIN_ID
            ])
            ->andReturn(false)
        ;

        $this->expectException(AuthenticatableNotFoundException::class);
        $this->auth->toRole('Admin', self::TOKEN);
    }

    public function testToRoleAdmin()
    {
        $this->jwtHelper->shouldReceive('parseToken')
            ->once()
            ->andReturn(self::ADMIN_CLAIMS)
        ;
        $this->adminGuard->shouldReceive('once')
            ->once()
            ->with([
                'id' => self::ADMIN_ID
            ])
            ->andReturn(true)
        ;
        $this->adminGuard->shouldReceive('user')
            ->once()
            ->andReturnUsing(function () {
                $user = new User();
                $user->id = self::ADMIN_ID;

                return $user;
            })
        ;

        $model = $this->auth->toRole('Admin', self::TOKEN);
        $this->assertInstanceOf(Authenticatable::class, $model);
        $this->assertEquals(self::ADMIN_ID, $model->getAuthIdentifier());
    }

    public function testToRoleUserNoUser()
    {
        $this->jwtHelper->shouldReceive('parseToken')
            ->once()
            ->andReturn(self::USER_CLAIMS)
        ;
        $this->userGuard->shouldReceive('once')
            ->once()
            ->with([
                'id' => self::USER_ID
            ])
            ->andReturn(false)
        ;

        $this->expectException(AuthenticatableNotFoundException::class);
        $this->auth->toRole('User', self::TOKEN);
    }

    public function testToRoleUser()
    {
        $this->jwtHelper->shouldReceive('parseToken')
            ->once()
            ->andReturn(self::USER_CLAIMS)
        ;
        $this->userGuard->shouldReceive('once')
            ->once()
            ->with([
                'id' => self::USER_ID
            ])
            ->andReturn(true)
        ;
        $this->userGuard->shouldReceive('user')
            ->atMost(1)
            ->andReturnUsing(function () {
                $user = new User();
                $user->id = self::USER_ID;

                return $user;
            })
        ;

        $model = $this->auth->toRole('User', self::TOKEN);
        $this->assertInstanceOf(Authenticatable::class, $model);
        $this->assertEquals(self::USER_ID, $model->getAuthIdentifier());
    }

    private function mockUserGuard()
    {
        $mock = \Mockery::mock(UserGuard::class);
        return $mock;
    }

    private function mockAdminGuard()
    {
        $mock = \Mockery::mock(AdminGuard::class);
        return $mock;
    }

    private function mockJwtHelper()
    {
        $mock = \Mockery::mock(JwtHelper::class);
        $mock->shouldReceive('createToken')
            ->atMost(1)
            ->andReturn(self::TOKEN)
        ;
        $mock->shouldReceive('validateClaims')
            ->atMost(1)
        ;

        return $mock;
    }
}
