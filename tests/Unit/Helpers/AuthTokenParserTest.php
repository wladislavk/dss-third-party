<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use Tests\TestCases\UnitTestCase;
use Tymon\JWTAuth\JWTAuth;
use DentalSleepSolutions\Helpers\AuthTokenParser;
use DentalSleepSolutions\Helpers\SudoHelper;
use Illuminate\Database\Eloquent\Collection;

class AuthTokenParserTest extends UnitTestCase
{
    const EMPTY_TOKEN = '';
    const INVALID_TOKEN = '-';
    const USER_TOKEN = 'user-token';
    const ADMIN_TOKEN = 'admin-token';
    const USER_ID = SudoHelper::USER_PREFIX . 1;
    const ADMIN_ID = SudoHelper::ADMIN_PREFIX . 1;

    /** @var AuthTokenParser */
    private $tokenParser;

    public function testGetAdminDataNoToken()
    {
        $token = self::EMPTY_TOKEN;
        $this->newAuthToken($token);
        $result = $this->tokenParser->getAdminData();

        $this->assertNull($result);
    }

    public function testGetAdminDataInvalidToken()
    {
        $token = self::INVALID_TOKEN;
        $this->newAuthToken($token);
        $result = $this->tokenParser->getAdminData();

        $this->assertNull($result);
    }

    public function testGetAdminDataUserToken()
    {
        $token = self::USER_TOKEN;
        $this->newAuthToken($token);
        $result = $this->tokenParser->getAdminData();

        $this->assertNull($result);
    }

    public function testGetAdminDataAdminToken()
    {
        $token = self::ADMIN_TOKEN;
        $this->newAuthToken($token);
        $result = $this->tokenParser->getAdminData();

        $this->assertNotNull($result);
        $this->assertEquals(self::ADMIN_ID, $result->id);
        $this->assertEquals(1, $result->admin);
    }

    public function testGetUserDataNoToken()
    {
        $token = self::EMPTY_TOKEN;
        $this->newAuthToken($token);
        $result = $this->tokenParser->getUserData();

        $this->assertNull($result);
    }

    public function testGetUserDataInvalidToken()
    {
        $token = self::INVALID_TOKEN;
        $this->newAuthToken($token);
        $result = $this->tokenParser->getUserData();

        $this->assertNull($result);
    }

    public function testGetUserDataAdminToken()
    {
        $token = self::ADMIN_TOKEN;
        $this->newAuthToken($token);
        $result = $this->tokenParser->getUserData();

        $this->assertNull($result);
    }

    public function testGetUserDataUserToken()
    {
        $token = self::USER_TOKEN;
        $this->newAuthToken($token);
        $result = $this->tokenParser->getUserData();

        $this->assertNotNull($result);
        $this->assertEquals(self::USER_ID, $result->id);
        $this->assertEquals(0, $result->admin);
    }

    private function newAuthToken($token)
    {
        $auth = $this->mockJWTAuth($token);
        $userRepository = $this->mockUserRepository();
        $this->tokenParser = new AuthTokenParser($auth, $userRepository);
    }

    private function newUser()
    {
        $resource = new User();
        $resource->id = self::USER_ID;
        $resource->admin = 0;

        return $resource;
    }

    private function newAdmin()
    {
        $resource = $this->newUser();
        $resource->id = self::ADMIN_ID;
        $resource->admin = 1;

        return $resource;
    }

    private function mockJWTAuth($token)
    {
        $auth = \Mockery::mock(JWTAuth::class);

        $auth->shouldReceive('getToken')
            ->atMost()
            ->times(1)
            ->andReturn($token);

        $auth->shouldReceive('toUser')
            ->atMost()
            ->times(1)
            ->andReturnUsing(function () use ($token) {
                if ($token === self::USER_TOKEN) {
                    return $this->mockCollection([$this->newUser()]);
                }

                if ($token === self::ADMIN_TOKEN) {
                    return $this->mockCollection([$this->newAdmin()]);
                }

                return $this->mockCollection();
            });

        return $auth;
    }

    private function mockCollection(array $collection = [])
    {
        $mock = \Mockery::mock(Collection::class, [$collection]);
        $mock->shouldReceive('count')
            ->atMost()
            ->times(1)
            ->passthru()
        ;
        $mock->shouldReceive('all')
            ->atMost()
            ->times(1)
            ->passthru()
        ;

        return $mock;
    }

    private function mockUserRepository()
    {
        $mock = \Mockery::mock(UserRepository::class);
        $mock->shouldReceive('isAid')
            ->atMost()
            ->times(1)
            ->andReturnUsing(function ($fieldValue) {
                if ($fieldValue === self::ADMIN_ID) {
                    return true;
                }

                return false;
            })
        ;
        $mock->shouldReceive('isUid')
            ->atMost()
            ->times(1)
            ->andReturnUsing(function ($fieldValue) {
                if ($fieldValue === self::USER_ID) {
                    return true;
                }

                return false;
            })
        ;

        return $mock;
    }
}
