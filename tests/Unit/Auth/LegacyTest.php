<?php

namespace Tests\Unit\Auth;

use DentalSleepSolutions\Auth\Legacy;
use Illuminate\Auth\AuthManager;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use DentalSleepSolutions\Eloquent\Models\User;
use Illuminate\Support\Arr;
use Tests\TestCases\UnitTestCase;

class LegacyTest extends UnitTestCase
{
    const USERNAME = 'username';
    const PASSWORD = 'password';
    const USER_ID = User::USER_PREFIX . '1';
    const ADMIN_ID = User::ADMIN_PREFIX . '1';
    const INVALID_ADMIN_ID = User::ADMIN_PREFIX . '2';

    /** @var Legacy */
    private $legacy;

    public function setUp()
    {
        $authManager = $this->mockAuthManager();
        $userRepository = $this->mockUserRepository();
        $this->legacy = new Legacy($authManager, $userRepository);
    }

    /**
     * @dataProvider byCredentialsDataProvider
     */
    public function testByCredentials($username, $password, $expectedResult)
    {
        $credentials = [
            'username' => $username,
            'password' => $password,
        ];
        $result = $this->legacy->byCredentials($credentials);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @dataProvider byIdDataProvider
     */
    public function testById($id, $expectedResult)
    {
        $result = $this->legacy->byId($id);
        $this->assertEquals($expectedResult, $result);
    }

    public function byCredentialsDataProvider()
    {
        return [
            [self::USERNAME, '', false],
            ['', self::PASSWORD, false],
            [self::USERNAME, self::PASSWORD, true],
        ];
    }

    public function byIdDataProvider()
    {
        return [
            [self::USER_ID, true],
            [$this->compositeId(self::ADMIN_ID, self::USER_ID), [true, true]],
            [$this->compositeId(self::INVALID_ADMIN_ID, self::USER_ID), false],
            [$this->compositeId(self::USER_ID, self::ADMIN_ID), false],
            [$this->compositeId(self::USER_ID, ''), false],
        ];
    }

    private function compositeId($firstId, $secondId)
    {
        return join(Legacy::LOGIN_ID_DELIMITER, [$firstId, $secondId]);
    }

    private function mockAuthManager()
    {
        $mock = \Mockery::mock(AuthManager::class);
        $mock->shouldReceive('login')
            ->atMost(1)
        ;
        $mock->shouldReceive('onceUsingId')
            ->atMost(2)
            ->andReturnUsing(function ($id) {
                if ($id === self::USER_ID) {
                    return true;
                }

                if ($id === self::ADMIN_ID) {
                    return true;
                }

                return null;
            })
        ;

        return $mock;
    }

    private function mockUserRepository()
    {
        $whereArguments = [];

        $mock = \Mockery::mock(UserRepository::class);
        $mock->shouldReceive('where')
            ->atMost(1)
            ->andReturnUsing(function ($arguments) use ($mock, &$whereArguments) {
                $whereArguments = $arguments;
                return $mock;
            })
        ;
        $mock->shouldReceive('first')
            ->atMost(1)
            ->andReturnUsing(function () use (&$whereArguments) {
                if (Arr::pull($whereArguments, 'username') === self::USERNAME) {
                    return $this->mockUser();
                }

                return null;
            })
        ;

        return $mock;
    }

    private function mockUser()
    {
        $mock = \Mockery::mock(User::class);
        $mock->shouldReceive('getAttribute')
            ->with('salt')
            ->andReturn('')
        ;
        $mock->shouldReceive('getAttribute')
            ->with('password')
            ->andReturn($this->hashPassword())
        ;

        return $mock;
    }

    private function hashPassword()
    {
        return hash('sha256', self::PASSWORD);
    }
}
