<?php

namespace Tests\Unit\Auth;

use DentalSleepSolutions\Auth\DentrixAuth as Auth;
use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Eloquent\Models\Dental\ExternalCompany as DentrixCompany;
use DentalSleepSolutions\Eloquent\Models\Dental\ExternalUser as DentrixUser;
use DentalSleepSolutions\Exceptions\Auth\AuthenticatableNotFoundException;
use DentalSleepSolutions\Exceptions\JWT\EmptyTokenException;
use DentalSleepSolutions\Providers\Auth\DentrixCompanyGuard;
use DentalSleepSolutions\Providers\Auth\DentrixUserGuard;
use DentalSleepSolutions\Providers\Auth\UserGuard;
use DentalSleepSolutions\Structs\DentrixAuthErrors;
use Tests\TestCases\UnitTestCase;

class DentrixAuthTest extends UnitTestCase
{
    const EMPTY_TOKEN = '';
    const INVALID_TOKEN = 'invalid';
    const TOKEN = 'token';

    /** @var string */
    private $dentrixCompanyState;

    /** @var string */
    private $dentrixUserState;

    /** @var string */
    private $userState;

    /** @var Auth */
    private $auth;

    public function setUp()
    {
        $this->dentrixCompanyState = '';
        $this->dentrixUserState = '';
        $this->userState = '';

        $dentrixCompanyGuard = $this->mockDentrixCompanyGuard();
        $dentrixUserGuard = $this->mockDentrixUserGuard();
        $userGuard = $this->mockUserGuard();
        $this->auth = new Auth($dentrixCompanyGuard, $dentrixUserGuard, $userGuard);
    }

    public function testToRoleDentrixCompanyNoToken()
    {
        $this->expectException(EmptyTokenException::class);
        $this->expectExceptionMessage(DentrixAuthErrors::COMPANY_TOKEN_MISSING);
        $this->auth->toRole('DentrixCompany', self::EMPTY_TOKEN);
    }

    public function testToRoleDentrixCompanyNoUser()
    {
        $this->expectException(AuthenticatableNotFoundException::class);
        $this->expectExceptionMessage(DentrixAuthErrors::COMPANY_TOKEN_INVALID);
        $this->auth->toRole('DentrixCompany', self::INVALID_TOKEN);
    }

    public function testToRoleDentrixCompany()
    {
        $model = $this->auth->toRole('DentrixCompany', self::TOKEN);
        $this->assertInstanceOf(DentrixCompany::class, $model);
    }

    public function testToRoleDentrixUserNoToken()
    {
        $this->expectException(EmptyTokenException::class);
        $this->expectExceptionMessage(DentrixAuthErrors::USER_TOKEN_MISSING);
        $this->auth->toRole('DentrixUser', self::EMPTY_TOKEN);
    }

    public function testToRoleDentrixUserNoUser()
    {
        $this->expectException(AuthenticatableNotFoundException::class);
        $this->expectExceptionMessage(DentrixAuthErrors::USER_TOKEN_INVALID);
        $this->auth->toRole('DentrixUser', self::INVALID_TOKEN);
    }

    public function testToRoleDentrixUser()
    {
        $model = $this->auth->toRole('DentrixUser', self::TOKEN);
        $this->assertInstanceOf(DentrixUser::class, $model);
    }

    public function testToRoleUserNoUser()
    {
        $this->expectException(AuthenticatableNotFoundException::class);
        $this->expectExceptionMessage(DentrixAuthErrors::USER_TOKEN_INVALID);
        $this->auth->toRole('User', self::INVALID_TOKEN);
    }

    public function testToRoleUser()
    {
        $model = $this->auth->toRole('User', self::TOKEN);
        $this->assertInstanceOf(User::class, $model);
    }

    public function testGuardDentrixCompany()
    {
        $result = $this->auth->guard('DentrixCompany');
        $this->assertInstanceOf(DentrixCompanyGuard::class, $result);
    }

    public function testGuardDentrixUser()
    {
        $result = $this->auth->guard('DentrixUser');
        $this->assertInstanceOf(DentrixUserGuard::class, $result);
    }

    public function testGuardUser()
    {
        $result = $this->auth->guard('User');
        $this->assertInstanceOf(UserGuard::class, $result);
    }

    public function testGuard()
    {
        $result = $this->auth->guard();
        $this->assertInstanceOf(UserGuard::class, $result);
    }

    private function mockDentrixCompanyGuard()
    {
        $mock = \Mockery::mock(DentrixCompanyGuard::class);
        $mock->shouldReceive('once')
            ->atMost(1)
            ->withAnyArgs([
                ['api_key' => self::INVALID_TOKEN],
                ['api_key' => self::TOKEN],
            ])
            ->andReturnUsing(function ($token) {
                $this->dentrixCompanyState = $token;

                if (self::TOKEN === $token) {
                    return true;
                }

                return false;
            })
        ;
        $mock->shouldReceive('user')
            ->atMost(1)
            ->andReturnUsing(function () {
                if (self::TOKEN === $this->dentrixCompanyState) {
                    return new DentrixCompany();
                }

                return null;
            })
        ;

        return $mock;
    }

    private function mockDentrixUserGuard()
    {
        $mock = \Mockery::mock(DentrixUserGuard::class);
        $mock->shouldReceive('once')
            ->atMost(1)
            ->withAnyArgs([
                ['api_key' => self::INVALID_TOKEN],
                ['api_key' => self::TOKEN],
            ])
            ->andReturnUsing(function ($token) {
                $this->dentrixUserState = $token;

                if (self::TOKEN === $token) {
                    return true;
                }

                return false;
            })
        ;
        $mock->shouldReceive('user')
            ->atMost(1)
            ->andReturnUsing(function () {
                if (self::TOKEN === $this->dentrixUserState) {
                    return new DentrixUser();
                }

                return null;
            })
        ;

        return $mock;
    }

    private function mockUserGuard()
    {
        $mock = \Mockery::mock(UserGuard::class);
        $mock->shouldReceive('loginUsingId')
            ->atMost(1)
            ->withAnyArgs([
                self::INVALID_TOKEN,
                self::TOKEN
            ])
            ->andReturnUsing(function ($token) {
                $this->userState = $token;

                if (self::TOKEN === $token) {
                    return true;
                }

                return false;
            })
        ;
        $mock->shouldReceive('user')
            ->atMost(1)
            ->andReturnUsing(function () {
                if (self::TOKEN === $this->userState) {
                    return new User();
                }

                return null;
            })
        ;
        return $mock;
    }
}
