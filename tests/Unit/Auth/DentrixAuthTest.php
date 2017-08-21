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
    const TOKEN = 'token';
    const EMPTY_TOKEN = '';

    /** @var DentrixCompanyGuard */
    private $dentrixCompanyGuard;

    /** @var DentrixUserGuard */
    private $dentrixUserGuard;

    /** @var UserGuard */
    private $userGuard;

    /** @var Auth */
    private $auth;

    public function setUp()
    {
        $this->dentrixCompanyGuard = $this->mockDentrixCompanyGuard();
        $this->dentrixUserGuard = $this->mockDentrixUserGuard();
        $this->userGuard = $this->mockUserGuard();
        $this->auth = new Auth($this->dentrixCompanyGuard, $this->dentrixUserGuard, $this->userGuard);
    }

    public function testToRoleDentrixCompanyNoToken()
    {
        $this->expectException(EmptyTokenException::class);
        $this->expectExceptionMessage(DentrixAuthErrors::COMPANY_TOKEN_MISSING);
        $this->auth->toRole('DentrixCompany', self::EMPTY_TOKEN);
    }

    public function testToRoleDentrixCompanyNoUser()
    {
        $this->dentrixCompanyGuard
            ->shouldReceive('once')
            ->once()
            ->with([
                'api_key' => self::TOKEN
            ])
            ->andReturn(false)
        ;

        $this->expectException(AuthenticatableNotFoundException::class);
        $this->expectExceptionMessage(DentrixAuthErrors::COMPANY_TOKEN_INVALID);
        $this->auth->toRole('DentrixCompany', self::TOKEN);
    }

    public function testToRoleDentrixCompany()
    {
        $this->dentrixCompanyGuard
            ->shouldReceive('once')
            ->once()
            ->with([
                'api_key' => self::TOKEN
            ])
            ->andReturn(true)
        ;
        $this->dentrixCompanyGuard
            ->shouldReceive('user')
            ->once()
            ->andReturn(new DentrixCompany())
        ;

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
        $this->dentrixUserGuard
            ->shouldReceive('once')
            ->once()
            ->with([
                'api_key' => self::TOKEN
            ])
            ->andReturn(false)
        ;

        $this->expectException(AuthenticatableNotFoundException::class);
        $this->expectExceptionMessage(DentrixAuthErrors::USER_TOKEN_INVALID);
        $this->auth->toRole('DentrixUser', self::TOKEN);
    }

    public function testToRoleDentrixUser()
    {
        $this->dentrixUserGuard
            ->shouldReceive('once')
            ->once()
            ->with([
                'api_key' => self::TOKEN
            ])
            ->andReturn(true)
        ;
        $this->dentrixUserGuard
            ->shouldReceive('user')
            ->once()
            ->andReturn(new DentrixUser())
        ;

        $model = $this->auth->toRole('DentrixUser', self::TOKEN);
        $this->assertInstanceOf(DentrixUser::class, $model);
    }

    public function testToRoleUserNoUser()
    {
        $this->userGuard
            ->shouldReceive('loginUsingId')
            ->once()
            ->with(self::TOKEN)
            ->andReturn(false)
        ;

        $this->expectException(AuthenticatableNotFoundException::class);
        $this->expectExceptionMessage(DentrixAuthErrors::USER_TOKEN_INVALID);
        $this->auth->toRole('User', self::TOKEN);
    }

    public function testToRoleUser()
    {
        $this->userGuard
            ->shouldReceive('loginUsingId')
            ->once()
            ->with(self::TOKEN)
            ->andReturn(true)
        ;
        $this->userGuard
            ->shouldReceive('user')
            ->once()
            ->andReturn(new User())
        ;

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
        return $mock;
    }

    private function mockDentrixUserGuard()
    {
        $mock = \Mockery::mock(DentrixUserGuard::class);
        return $mock;
    }

    private function mockUserGuard()
    {
        $mock = \Mockery::mock(UserGuard::class);
        return $mock;
    }
}
