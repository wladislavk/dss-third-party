<?php

namespace Tests\Unit\Auth;

use DentalSleepSolutions\Auth\Legacy;
use DentalSleepSolutions\Helpers\SudoHelper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Auth\AuthManager;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use DentalSleepSolutions\Eloquent\Models\User;
use Illuminate\Support\Arr;
use Tests\TestCases\UnitTestCase;

class LegacyTest extends UnitTestCase
{
    const USERNAME = 'username';
    const PASSWORD = 'password';
    const SALT = '';
    const USER_ID = SudoHelper::USER_PREFIX . '1';
    const INVALID_USER_ID = self::USER_ID . '2';

    /** @var array */
    private $whereArguments;

    /** @var Legacy */
    private $legacy;

    public function setUp()
    {
        $authManager = $this->mockAuthManager();
        $userRepository = $this->mockUserRepository();
        $this->legacy = new Legacy($authManager, $userRepository);
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

    public function testHashPassword()
    {
        $result = $this->legacy->hashPassword(self::PASSWORD, self::SALT);
        $this->assertEquals(hash('sha256', self::PASSWORD . self::SALT), $result);
    }

    public function testByIdInvalidId()
    {
        $result = $this->legacy->byId(self::INVALID_USER_ID);
        $this->assertFalse($result);
    }

    public function testByIdValidId()
    {
        $result = $this->legacy->byId(self::USER_ID);
        $this->assertCount(1, $result);
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
                    return $this->mockCollection([true]);
                }

                return $this->mockCollection();
            })
        ;

        return $mock;
    }

    private function newUser()
    {
        $user = new User();
        $user->salt = self::SALT;
        $user->password = hash('sha256', self::PASSWORD . self::SALT);

        return $user;
    }

    private function mockCollection(array $collection = [])
    {
        $mock = \Mockery::mock(Collection::class, $collection);
        $mock->shouldReceive('count')
            ->passthru()
        ;
        $mock->shouldReceive('all')
            ->passthru()
        ;

        return $mock;
    }
}
