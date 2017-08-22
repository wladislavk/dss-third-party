<?php

namespace Tests\Unit\Auth;

use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Exceptions\Auth\AuthenticatableNotFoundException;
use DentalSleepSolutions\Helpers\JwtHelper;
use DentalSleepSolutions\Providers\Auth\AdminGuard;
use DentalSleepSolutions\Providers\Auth\UserGuard;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\TestCases\UnitTestCase;

class JwtAuthTest extends UnitTestCase
{
    const ADMIN_ID = 'a_1';
    const USER_ID = 'u_1';
    const EMPTY_ID = '';
    const ADMIN_CLAIMS = [
        JwtAuth::CLAIM_ROLE_INDEX => JwtAuth::ROLE_ADMIN,
        JwtAuth::MODEL_KEY => self::ADMIN_ID
    ];
    const USER_CLAIMS = [
        JwtAuth::CLAIM_ROLE_INDEX => JwtAuth::ROLE_USER,
        JwtAuth::MODEL_KEY => self::USER_ID
    ];
    const INVALID_CLAIMS = [
        JwtAuth::CLAIM_ROLE_INDEX => JwtAuth::ROLE_USER,
        JwtAuth::MODEL_KEY => self::EMPTY_ID
    ];
    const ADMIN_TOKEN = 'admin-token';
    const USER_TOKEN = 'user-token';
    const INVALID_TOKEN = '';

    /** @var string */
    private $userGuardState;

    /** @var string */
    private $adminGuardState;

    /** @var JwtAuth */
    private $auth;

    public function setUp()
    {
        $this->userGuardState = '';
        $this->adminGuardState = '';
        $userGuard = $this->mockUserGuard();
        $adminGuard = $this->mockAdminGuard();
        $jwtHelper = $this->mockJwtHelper();
        $this->auth = new JwtAuth($userGuard, $adminGuard, $jwtHelper);
    }

    public function testToTokenNoUser()
    {
        $this->setUserGuardState(self::EMPTY_ID);
        $this->expectException(AuthenticatableNotFoundException::class);
        $this->auth->toToken(JwtAuth::ROLE_USER);
    }

    public function testToToken()
    {
        $this->setUserGuardState(self::USER_ID);
        $token = $this->auth->toToken(JwtAuth::ROLE_USER);
        $this->assertEquals(self::USER_TOKEN, $token);
    }

    public function testToRoleAdminNoUser()
    {
        $this->expectException(AuthenticatableNotFoundException::class);
        $this->auth->toRole(JwtAuth::ROLE_ADMIN, self::INVALID_TOKEN);
    }

    public function testToRoleAdmin()
    {
        $model = $this->auth->toRole(JwtAuth::ROLE_ADMIN, self::ADMIN_TOKEN);
        $this->assertInstanceOf(Authenticatable::class, $model);
        $this->assertEquals(self::ADMIN_ID, $model->getAuthIdentifier());
    }

    public function testToRoleUserNoUser()
    {
        $this->expectException(AuthenticatableNotFoundException::class);
        $this->auth->toRole(JwtAuth::ROLE_USER, self::INVALID_TOKEN);
    }

    public function testToRoleUser()
    {
        $model = $this->auth->toRole(JwtAuth::ROLE_USER, self::USER_TOKEN);
        $this->assertInstanceOf(Authenticatable::class, $model);
        $this->assertEquals(self::USER_ID, $model->getAuthIdentifier());
    }

    public function testGuardAdmin()
    {
        $result = $this->auth->guard(JwtAuth::ROLE_ADMIN);
        $this->assertInstanceOf(AdminGuard::class, $result);
    }

    public function testGuardUser()
    {
        $result = $this->auth->guard(JwtAuth::ROLE_USER);
        $this->assertInstanceOf(UserGuard::class, $result);
    }

    public function testGuard()
    {
        $result = $this->auth->guard();
        $this->assertInstanceOf(UserGuard::class, $result);
    }

    private function mockUserGuard()
    {
        $mock = \Mockery::mock(UserGuard::class);
        $mock->shouldReceive('user')
            ->atMost(1)
            ->andReturnUsing(function () {
                if (self::USER_ID === $this->userGuardState) {
                    $user = new User();
                    $user->id = self::USER_ID;

                    return $user;
                }

                return null;
            })
        ;
        $mock->shouldReceive('once')
            ->withAnyArgs([
                [JwtAuth::CLAIM_ID_INDEX => self::USER_ID],
                [JwtAuth::CLAIM_ID_INDEX => self::EMPTY_ID],
            ])
            ->atMost(1)
            ->andReturnUsing(function (array $credentials) {
                $this->userGuardState = $credentials[JwtAuth::CLAIM_ID_INDEX];

                if (self::USER_ID === $this->userGuardState) {
                    return true;
                }

                return false;
            })
        ;

        return $mock;
    }

    private function mockAdminGuard()
    {
        $mock = \Mockery::mock(AdminGuard::class);
        $mock->shouldReceive('user')
            ->atMost(1)
            ->andReturnUsing(function () {
                if (self::ADMIN_ID === $this->adminGuardState) {
                    $user = new User();
                    $user->id = self::ADMIN_ID;

                    return $user;
                }

                return null;
            })
        ;
        $mock->shouldReceive('once')
            ->withAnyArgs([
                [JwtAuth::CLAIM_ID_INDEX => self::ADMIN_ID],
                [JwtAuth::CLAIM_ID_INDEX => self::EMPTY_ID],
            ])
            ->atMost(1)
            ->andReturnUsing(function (array $credentials) {
                $this->adminGuardState = $credentials[JwtAuth::CLAIM_ID_INDEX];

                if (self::ADMIN_ID === $this->adminGuardState) {
                    return true;
                }

                return false;
            })
        ;

        return $mock;
    }

    private function mockJwtHelper()
    {
        $mock = \Mockery::mock(JwtHelper::class);
        $mock->shouldReceive('createToken')
            ->atMost(1)
            ->andReturn(self::USER_TOKEN)
        ;
        $mock->shouldReceive('parseToken')
            ->atMost(1)
            ->andReturnUsing(function ($token) {
                if (self::USER_TOKEN === $token) {
                    return self::USER_CLAIMS;
                }

                if (self::ADMIN_TOKEN === $token) {
                    return self::ADMIN_CLAIMS;
                }

                return self::INVALID_CLAIMS;
            })
        ;
        $mock->shouldReceive('validateClaims')
            ->atMost(1)
        ;

        return $mock;
    }

    private function setUserGuardState($state)
    {
        $this->userGuardState = $state;
    }
}
