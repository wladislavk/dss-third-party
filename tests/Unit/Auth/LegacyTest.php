<?php

namespace Tests\Unit\Auth;

use DentalSleepSolutions\Auth\Legacy;
use DentalSleepSolutions\StaticClasses\SudoHelper;
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
    const ADMIN_ID = SudoHelper::ADMIN_PREFIX . '1';
    const INVALID_ADMIN_ID = SudoHelper::ADMIN_PREFIX . '2';

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
        $this->assertEquals(false, $result);
    }

    public function testInvalidPassword()
    {
        $credentials = [
            'username' => self::USERNAME,
            'password' => '',
        ];
        $result = $this->legacy->byCredentials($credentials);
        $this->assertEquals(false, $result);
    }

    public function testValidCredentials()
    {
        $credentials = [
            'username' => self::USERNAME,
            'password' => self::PASSWORD,
        ];
        $result = $this->legacy->byCredentials($credentials);
        $this->assertEquals(true, $result);
    }

    public function testHashPassword()
    {
        $result = $this->legacy->hashPassword(self::PASSWORD, self::SALT);
        $this->assertEquals($this->hashPassword(), $result);
    }

    /**
     * @dataProvider byIdDataProvider
     */
    public function testById($perCaseDescription, $id, $expectedResult)
    {
        $actualResult = $this->legacy->byId($id);
        $this->assertEquals($expectedResult, $actualResult, $perCaseDescription);
    }

    public function byIdDataProvider()
    {
        return [
            [
                'USER_ID is a valid ID',
                self::USER_ID,
                true
            ],
            [
                'Sudo ADMIN_ID/USER_ID is a valid ID, method returns array',
                self::ADMIN_ID . SudoHelper::LOGIN_ID_DELIMITER . self::USER_ID,
                [true, true]
            ],
            [
                'Sudo INVALID_ADMIN_ID/USER_ID is not a valid ID',
                self::INVALID_ADMIN_ID . SudoHelper::LOGIN_ID_DELIMITER . self::USER_ID,
                false
            ],
            [
                'Sudo USER_ID/ADMIN_ID is not a valid ID',
                self::USER_ID . SudoHelper::LOGIN_ID_DELIMITER . self::ADMIN_ID,
                false
            ],
            [
                'Incomplete composite ID is not a valid ID',
                self::USER_ID . SudoHelper::LOGIN_ID_DELIMITER,
                false
            ],
        ];
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
        $this->whereArguments = [];

        $mock = \Mockery::mock(UserRepository::class);
        $mock->shouldReceive('findWhere')
            ->atMost(1)
            ->andReturnUsing(function (array $arguments) use ($mock) {
                $this->whereArguments = $arguments;
                return $mock;
            })
        ;
        $mock->shouldReceive('first')
            ->atMost(1)
            ->andReturnUsing(function () {
                if (Arr::pull($this->whereArguments, 'username') === self::USERNAME) {
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
            ->andReturn(self::SALT)
        ;
        $mock->shouldReceive('getAttribute')
            ->with('password')
            ->andReturn($this->hashPassword())
        ;

        return $mock;
    }

    private function hashPassword()
    {
        return hash('sha256', self::PASSWORD . self::SALT);
    }
}
