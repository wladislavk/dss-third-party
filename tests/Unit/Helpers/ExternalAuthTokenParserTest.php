<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\SudoHelper;
use DentalSleepSolutions\Structs\ExternalAuthTokenErrors;
use Tests\TestCases\UnitTestCase;
use DentalSleepSolutions\Helpers\ExternalAuthTokenParser;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalCompanyRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalUserRepository;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use DentalSleepSolutions\Eloquent\Models\User;
use Illuminate\Http\Request;

class ExternalAuthTokenParserTest extends UnitTestCase
{
    const EMPTY_TOKEN = '';
    const COMPANY_TOKEN = 'company_key';
    const USER_TOKEN = 'user_key';
    const INVALID_COMPANY_TOKEN = 'company_invalid_token';
    const INVALID_USER_TOKEN = 'user_invalid_token';

    const USER_ID = 1;
    const USER_VIEW_ID = SudoHelper::USER_PREFIX . self::USER_ID;
    
    /** @var ExternalAuthTokenParser */
    private $tokenParser;

    public function testValidationErrorCompanyKeyMissing()
    {
        $companyKey = self::EMPTY_TOKEN;
        $userKey = self::USER_TOKEN;

        $this->newAuthToken($companyKey, $userKey);
        $result = $this->tokenParser->validationError();
        $this->assertEquals(ExternalAuthTokenErrors::COMPANY_KEY_MISSING, $result);
    }

    public function testValidationErrorUserKeyMissing()
    {
        $companyKey = self::COMPANY_TOKEN;
        $userKey = self::EMPTY_TOKEN;

        $this->newAuthToken($companyKey, $userKey);
        $result = $this->tokenParser->validationError();
        $this->assertEquals(ExternalAuthTokenErrors::USER_KEY_MISSING, $result);
    }

    public function testValidationCompanyKeyInvalid()
    {
        $companyKey = self::INVALID_COMPANY_TOKEN;
        $userKey = self::USER_TOKEN;

        $this->newAuthToken($companyKey, $userKey);
        $result = $this->tokenParser->validationError();
        $this->assertEquals(ExternalAuthTokenErrors::COMPANY_KEY_INVALID, $result);
    }

    public function testValidationUserKeyInvalid()
    {
        $companyKey = self::COMPANY_TOKEN;
        $userKey = self::INVALID_USER_TOKEN;

        $this->newAuthToken($companyKey, $userKey);
        $result = $this->tokenParser->validationError();
        $this->assertEquals(ExternalAuthTokenErrors::USER_KEY_INVALID, $result);
    }

    public function testValidationUserNotFound()
    {
        $companyKey = self::COMPANY_TOKEN;
        $userKey = self::USER_TOKEN;

        $this->newAuthToken($companyKey, $userKey, true);
        $result = $this->tokenParser->validationError();
        $this->assertEquals(ExternalAuthTokenErrors::USER_NOT_FOUND, $result);
    }

    public function testGetUserDataValidationError()
    {
        $companyKey = self::INVALID_COMPANY_TOKEN;
        $userKey = self::USER_TOKEN;

        $this->newAuthToken($companyKey, $userKey);
        $result = $this->tokenParser->getUserData();
        $this->assertNull($result);
    }

    public function testGetUserData()
    {
        $companyKey = self::COMPANY_TOKEN;
        $userKey = self::USER_TOKEN;

        $this->newAuthToken($companyKey, $userKey);
        $result = $this->tokenParser->getUserData();
        $this->assertNotNull($result);
        $this->assertEquals(self::USER_ID, $result->id);
    }

    private function newAuthToken($companyKey, $userKey, $userNotFound = false)
    {
        $this->tokenParser = new ExternalAuthTokenParser(
            $this->mockExternalCompanyRepository(),
            $this->mockExternalUserRepository(),
            $this->mockUserRepository($userNotFound),
            $this->mockRequest($companyKey, $userKey)
        );
    }

    public function newUser()
    {
        $user = new User();
        $user->user_id = self::USER_ID;
        $user->id = self::USER_ID;
        $user->admin = 0;

        return $user;
    }

    public function newUserView()
    {
        $user = $this->newUser();
        $user->id = self::USER_VIEW_ID;

        return $user;
    }

    private function mockExternalCompanyRepository()
    {
        $mock = \Mockery::mock(ExternalCompanyRepository::class);
        $mock->shouldReceive('findByApiKey')
            ->with(\Mockery::anyOf(self::EMPTY_TOKEN, self::COMPANY_TOKEN, self::INVALID_COMPANY_TOKEN))
            ->atMost()
            ->times(1)
            ->andReturnUsing(function ($fieldValue) {
                if ($fieldValue === self::COMPANY_TOKEN) {
                    return true;
                }

                return false;
            })
        ;

        return $mock;
    }

    private function mockExternalUserRepository()
    {
        $mock = \Mockery::mock(ExternalUserRepository::class);
        $mock->shouldReceive('findByApiKey')
            ->with(\Mockery::anyOf(self::EMPTY_TOKEN, self::USER_TOKEN, self::INVALID_USER_TOKEN))
            ->atMost()
            ->times(2)
            ->andReturnUsing(function ($fieldValue) {
                if ($fieldValue === self::USER_TOKEN) {
                    return $this->newUserView();
                }

                return null;
            })
        ;

        return $mock;
    }

    private function mockUserRepository($userNotFound)
    {
        $mock = \Mockery::mock(UserRepository::class);
        $mock->shouldReceive('findByUid')
            ->atMost()
            ->times(2)
            ->andReturnUsing(function ($fieldValue) use ($userNotFound) {
                if ($userNotFound) {
                    return null;
                }

                if ($fieldValue === self::USER_ID) {
                    return $this->newUser();
                }

                return null;
            })
        ;

        return $mock;
    }

    private function mockRequest($companyKey, $userKey)
    {
        $mock = \Mockery::mock(Request::class);
        $mock->shouldReceive('input')
            ->times(2)
            ->andReturnUsing(function ($fieldValue, $default) use ($companyKey, $userKey) {
                if ($fieldValue === ExternalAuthTokenParser::COMPANY_KEY_INDEX) {
                    return $companyKey;
                }

                if ($fieldValue === ExternalAuthTokenParser::USER_KEY_INDEX) {
                    return $userKey;
                }

                return $default;
            })
        ;

        return $mock;
    }
}
