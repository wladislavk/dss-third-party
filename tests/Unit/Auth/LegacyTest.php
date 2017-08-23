<?php

namespace Tests\Unit\Auth;

use DentalSleepSolutions\Auth\Legacy;
use DentalSleepSolutions\Contracts\PasswordInterface;
use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use DentalSleepSolutions\Helpers\PasswordGenerator;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\Arr;
use Tests\TestCases\UnitTestCase;

class LegacyTest extends UnitTestCase
{
    const USERNAME = 'username';
    const PASSWORD = 'password';
    const SALT = 'salt';
    const HASH = 'hash';
    const USER_ID = 'u_1';
    const INVALID_USER_ID = self::USER_ID . '2';
    const PASSWORD_GENERATOR_VERIFY = 'verify';

    /** @var array */
    private $whereArguments;

    /** @var Legacy */
    private $legacy;

    public function setUp()
    {
        $authManager = $this->mockAuthManager();
        $userRepository = $this->mockUserRepository();
        $passwordGenerator = $this->mockPasswordGenerator();
        $this->legacy = new Legacy($authManager, $userRepository, $passwordGenerator);
    }

    public function testInvalidUsername()
    {
        $credentials = [
            'username' => '',
            'password' => self::PASSWORD,
        ];
        $result = $this->legacy->byCredentials($credentials);
        $this->assertFalse($result);
    }

    public function testInvalidPassword()
    {
        $credentials = [
            'username' => self::USERNAME,
            'password' => '',
        ];
        $result = $this->legacy->byCredentials($credentials);
        $this->assertFalse($result);
    }

    public function testValidCredentials()
    {
        $credentials = [
            'username' => self::USERNAME,
            'password' => self::PASSWORD,
        ];
        $result = $this->legacy->byCredentials($credentials);
        $this->assertTrue($result);
    }

    public function testByIdInvalidId()
    {
        $result = $this->legacy->byId(self::INVALID_USER_ID);
        $this->assertEmpty($result);
    }

    public function testByIdValidId()
    {
        $result = $this->legacy->byId(self::USER_ID);
        $this->assertTrue($result);
    }

    private function mockAuthManager()
    {
        $mock = \Mockery::mock(AuthManager::class);
        $mock->shouldReceive('login')
            ->atMost(1)
        ;

        return $mock;
    }

    private function mockUserRepository()
    {
        $this->whereArguments = [];

        $mock = \Mockery::mock(UserRepository::class);
        $mock->shouldReceive('findByCredentials')
            ->atMost(1)
            ->andReturnUsing(function (array $where) {
                if (Arr::pull($where, 'username') === self::USERNAME) {
                    return $this->newUser();
                }

                return null;
            })
        ;
        $mock->shouldReceive('findById')
            ->atMost(1)
            ->andReturnUsing(function ($id) {
                if ($id === self::USER_ID) {
                    return true;
                }

                return false;
            })
        ;

        return $mock;
    }

    private function mockPasswordGenerator()
    {
        $mock = \Mockery::mock(PasswordGenerator::class);
        $mock->shouldReceive('verify')
            ->andReturnUsing(function ($password, $hashedPassword, $salt) {
                if (
                    $password === self::PASSWORD
                    && $hashedPassword === self::HASH
                ) {
                    return true;
                }

                return false;
            })
        ;

        return $mock;
    }

    private function newUser()
    {
        $user = new User();
        $user->salt = self::SALT;
        $user->password = self::HASH;

        return $user;
    }
}
