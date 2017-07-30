<?php

namespace Tests\Unit\Auth;

use DentalSleepSolutions\Auth\Legacy;
use Illuminate\Auth\AuthManager;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use DentalSleepSolutions\Eloquent\Models\User;
use Illuminate\Support\Arr;
use const LDAP_ESCAPE_DN;
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

    public function testIsSimpleId()
    {
        $result = $this->legacy->isSimpleId('');
        $this->assertTrue($result);

        $result = $this->legacy->isSimpleId(Legacy::LOGIN_ID_DELIMITER);
        $this->assertFalse($result);
    }

    public function testIsValidCompositeId()
    {
        $result = $this->legacy->isValidCompositeId('');
        $this->assertFalse($result);

        $result = $this->legacy->isValidCompositeId(self::ADMIN_ID . Legacy::LOGIN_ID_DELIMITER . self::USER_ID);
        $this->assertTrue($result);
    }

    public function testComposeId()
    {
        $result = $this->legacy->composeId(self::ADMIN_ID, self::USER_ID);
        $this->assertEquals(self::ADMIN_ID . Legacy::LOGIN_ID_DELIMITER . self::USER_ID, $result);
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
            [self::ADMIN_ID . Legacy::LOGIN_ID_DELIMITER . self::USER_ID, [true, true]],
            [self::INVALID_ADMIN_ID . Legacy::LOGIN_ID_DELIMITER . self::USER_ID, false],
            [self::USER_ID . Legacy::LOGIN_ID_DELIMITER . self::ADMIN_ID, false],
            [self::USER_ID . Legacy::LOGIN_ID_DELIMITER, false],
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
