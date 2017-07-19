<?php

namespace Tests\Unit\Helpers;

use Tests\TestCases\UnitTestCase;
use DentalSleepSolutions\Helpers\ExternalAuthTokenParser;
use DentalSleepSolutions\Contracts\Repositories\ExternalCompanies;
use DentalSleepSolutions\Contracts\Repositories\ExternalUsers;
use DentalSleepSolutions\Eloquent\User;

class ExternalAuthTokenParserTest extends UnitTestCase
{
    const EMPTY_TOKEN = '';
    const COMPANY_TOKEN = 'company_key';
    const USER_TOKEN = 'user_key';
    const INVALID_COMPANY_TOKEN = 'company_invalid_token';
    const INVALID_USER_TOKEN = 'user_invalid_token';

    const USER_ID = 1;
    const USER_VIEW_ID = 'u_1';
    
    /** @var ExternalAuthTokenParser */
    private $tokenParser;

    /**
     * @dataProvider tokenDataProvider
     */
    public function testTokens($companyToken, $userToken, $userData)
    {
        $this->mockAuthToken();
        $user = $this->tokenParser->getUserData($companyToken, $userToken);
        $this->assertEquals($user, $userData);
    }

    public function tokenDataProvider()
    {
        return [
            [self::EMPTY_TOKEN, self::EMPTY_TOKEN, null],
            [self::EMPTY_TOKEN, self::USER_TOKEN, null],
            [self::COMPANY_TOKEN, self::EMPTY_TOKEN, null],
            [self::INVALID_COMPANY_TOKEN, self::INVALID_USER_TOKEN, null],
            [self::INVALID_COMPANY_TOKEN, self::USER_TOKEN, null],
            [self::COMPANY_TOKEN, self::INVALID_USER_TOKEN, null],
            [self::COMPANY_TOKEN, self::USER_TOKEN, $this->mockUser()],
        ];
    }

    private function mockAuthToken()
    {
        $this->tokenParser = new ExternalAuthTokenParser(
            $this->mockExternalCompanies(),
            $this->mockExternalUsers(),
            $this->mockUserResource()
        );
    }

    public function mockUser()
    {
        $user = new User();
        $user->user_id = self::USER_ID;
        $user->id = self::USER_ID;
        $user->admin = 0;

        return $user;
    }

    public function mockUserView()
    {
        $user = $this->mockUser();
        $user->id = self::USER_VIEW_ID;

        return $user;
    }

    private function mockExternalCompanies()
    {
        $repository = \Mockery::mock(ExternalCompanies::class);
        $token = null;

        $repository->shouldReceive('where')
            ->with('api_key', \Mockery::anyOf(self::EMPTY_TOKEN, self::COMPANY_TOKEN, self::INVALID_COMPANY_TOKEN))
            ->atMost()
            ->times(1)
            ->andReturnUsing(function ($fieldName, $fieldValue) use (&$token, $repository) {
                $token = $fieldValue;
                return $repository;
            });

        $repository->shouldReceive('first')
            ->atMost()
            ->times(1)
            ->andReturnUsing(function () use (&$token) {
                if ($token === self::COMPANY_TOKEN) {
                    return true;
                }

                return false;
            });

        return $repository;
    }

    private function mockExternalUsers()
    {
        $repository = \Mockery::mock(ExternalUsers::class);
        $token = null;

        $repository->shouldReceive('where')
            ->with('api_key', \Mockery::anyOf(self::EMPTY_TOKEN, self::USER_TOKEN, self::INVALID_USER_TOKEN))
            ->atMost()
            ->times(1)
            ->andReturnUsing(function ($fieldName, $fieldValue) use (&$token, $repository) {
                $token = $fieldValue;
                return $repository;
            });

        $repository->shouldReceive('first')
            ->atMost()
            ->times(1)
            ->andReturnUsing(function () use (&$token) {
                if ($token === self::USER_TOKEN) {
                    return $this->mockUserView();
                }

                return null;
            });

        return $repository;
    }

    private function mockUserResource()
    {
        $repository = \Mockery::mock(User::class);

        $repository->shouldReceive('find')
            ->with(self::USER_VIEW_ID)
            ->atMost()
            ->times(1)
            ->andReturnSelf();

        $repository->shouldReceive('first')
            ->atMost()
            ->times(1)
            ->andReturn($this->mockUser());

        return $repository;
    }
}
