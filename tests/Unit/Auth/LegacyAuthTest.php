<?php

namespace Tests\Unit\Auth;

use DentalSleepSolutions\Auth\LegacyAuth;
use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use DentalSleepSolutions\Helpers\PasswordGenerator;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\Arr;
use Tests\TestCases\UnitTestCase;

class LegacyAuthTest extends UnitTestCase
{
    const USERNAME = 'username';
    const PASSWORD = 'password';
    const SALT = 'salt';
    const HASH = 'hash';
    const USER_ID = 'u_1';
    const INVALID_USER_ID = self::USER_ID . '2';
    const PASSWORD_GENERATOR_VERIFY = 'verify';

    /** @var LegacyAuth */
    private $legacyAuth;

    public function setUp()
    {
        $authManager = $this->mockAuthManager();
        $userRepository = $this->mockUserRepository();
        $passwordGenerator = $this->mockPasswordGenerator();
        $this->legacyAuth = new LegacyAuth($authManager, $userRepository, $passwordGenerator);
    }

    public function testInvalidUsername()
    {
        $credentials = [
            'username' => '',
            'password' => self::PASSWORD,
        ];
        $result = $this->legacyAuth->byCredentials($credentials);
        $this->assertFalse($result);
    }

    public function testInvalidPassword()
    {
        $credentials = [
            'username' => self::USERNAME,
            'password' => '',
        ];
        $result = $this->legacyAuth->byCredentials($credentials);
        $this->assertFalse($result);
    }

    public function testValidCredentials()
    {
        $credentials = [
            'username' => self::USERNAME,
            'password' => self::PASSWORD,
        ];
        $result = $this->legacyAuth->byCredentials($credentials);
        $this->assertTrue($result);
    }

    public function testByIdInvalidId()
    {
        $result = $this->legacyAuth->byId(self::INVALID_USER_ID);
        $this->assertEmpty($result);
    }

    public function testByIdValidId()
    {
        $result = $this->legacyAuth->byId(self::USER_ID);
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
