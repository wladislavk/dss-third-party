<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Models\User;
use const SUNFUNCS_RET_DOUBLE;
use Tests\TestCases\UnitTestCase;
use Tymon\JWTAuth\JWTAuth;
use DentalSleepSolutions\Helpers\AuthTokenParser;
use DentalSleepSolutions\StaticClasses\SudoHelper;

class AuthTokenParserTest extends UnitTestCase
{
    const USER_ID = 1;
    const ADMIN_ID = 1;
    const EMPTY_TOKEN = '';
    const USER_TOKEN_ID = SudoHelper::USER_PREFIX . self::USER_ID;
    const ADMIN_TOKEN_ID = SudoHelper::ADMIN_PREFIX . self::ADMIN_ID;
    const INVALID_USER_TOKEN_ID = SudoHelper::USER_PREFIX . '2';
    const INVALID_ADMIN_TOKEN_ID = SudoHelper::ADMIN_PREFIX . '2';

    /** @var JWTAuth */
    private $auth;

    /** @var AuthTokenParser */
    private $tokenParser;

    /**
     * @dataProvider tokenDataProvider
     */
    public function testToken($token, $user, $admin, $userId, $adminId)
    {
        $this->mockAuthToken($token);

        $userData = $this->tokenParser->getUserData();
        $adminData = $this->tokenParser->getAdminData();

        $this->assertEquals($userData, $user);
        $this->assertEquals($adminData, $admin);

        if ($userData) {
            $this->assertEquals($userData->id, $userId);
            $this->assertEquals($userData->admin, 0);
        }

        if ($adminData) {
            $this->assertEquals($adminData->id, $adminId);
            $this->assertEquals($adminData->admin, 1);
        }
    }

    public function tokenDataProvider()
    {
        return [
            [
                self::EMPTY_TOKEN,
                null,
                null,
                0,
                0,
            ],
            [
                self::USER_TOKEN_ID,
                $this->mockUserData(),
                null,
                self::USER_ID,
                0,
            ],
            [
                self::ADMIN_TOKEN_ID,
                null,
                $this->mockAdminData(),
                0,
                self::ADMIN_ID,
            ],
            [
                self::USER_TOKEN_ID . SudoHelper::LOGIN_ID_DELIMITER . self::ADMIN_TOKEN_ID,
                $this->mockUserData(),
                $this->mockAdminData(),
                self::USER_ID,
                self::ADMIN_ID,
            ],
            [
                self::ADMIN_TOKEN_ID . SudoHelper::LOGIN_ID_DELIMITER . self::USER_TOKEN_ID,
                $this->mockUserData(),
                $this->mockAdminData(),
                self::USER_ID,
                self::ADMIN_ID,
            ],
            [
                self::USER_TOKEN_ID . SudoHelper::LOGIN_ID_DELIMITER . self::INVALID_USER_TOKEN_ID,
                $this->mockUserData(),
                null,
                self::USER_ID,
                0,
            ],
            [
                self::ADMIN_TOKEN_ID . SudoHelper::LOGIN_ID_DELIMITER . self::INVALID_ADMIN_TOKEN_ID,
                null,
                $this->mockAdminData(),
                0,
                self::ADMIN_ID,
            ],
        ];
    }

    private function mockAuthToken($mockToken)
    {
        $this->auth = $this->mockJWTAuth($mockToken);
        $this->tokenParser = new AuthTokenParser($this->auth);
    }

    private function mockUserView()
    {
        $resource = new User();
        $resource->id = self::USER_TOKEN_ID;
        $resource->admin = 0;

        return $resource;
    }

    private function mockAdminView()
    {
        $resource = $this->mockUserView();
        $resource->id = self::ADMIN_TOKEN_ID;
        $resource->admin = 1;

        return $resource;
    }

    public function mockUserData()
    {
        $resource = $this->mockUserView();
        $resource->id = self::USER_ID;

        return $resource;
    }

    public function mockAdminData()
    {
        $resource = $this->mockAdminView();
        $resource->id = self::ADMIN_ID;

        return $resource;
    }

    private function mockJWTAuth($mockToken)
    {
        $auth = \Mockery::mock(JWTAuth::class);

        $auth->shouldReceive('getToken')
            ->twice()
            ->andReturn($mockToken);

        $auth->shouldReceive('toUser')
            ->atMost()
            ->times(2)
            ->andReturnUsing(function () use ($mockToken) {
                if ($mockToken === self::USER_TOKEN_ID) {
                    return $this->mockUserView();
                }
                
                if ($mockToken === self::ADMIN_TOKEN_ID) {
                    return $this->mockAdminView();
                }
                
                if ($mockToken === self::USER_TOKEN_ID . SudoHelper::LOGIN_ID_DELIMITER . self::ADMIN_TOKEN_ID) {
                    return [$this->mockUserView(), $this->mockAdminView()];
                }
                
                if ($mockToken === self::ADMIN_TOKEN_ID . SudoHelper::LOGIN_ID_DELIMITER . self::USER_TOKEN_ID) {
                    return [$this->mockAdminView(), $this->mockUserView()];
                }
                
                if (strpos($mockToken, self::USER_TOKEN_ID) === 0) {
                    return $this->mockUserView();
                }
                
                if (strpos($mockToken, self::ADMIN_TOKEN_ID) === 0) {
                    return $this->mockAdminView();
                }

                return $this->mockUserView();
            });

        return $auth;
    }
}
