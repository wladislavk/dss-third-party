<?php

namespace Tests\Unit\Helpers;

use Tests\TestCases\UnitTestCase;
use DentalSleepSolutions\Helpers\ExternalAuthTokenParser;
use DentalSleepSolutions\Contracts\Repositories\ExternalCompanies;
use DentalSleepSolutions\Contracts\Repositories\ExternalUsers;
use DentalSleepSolutions\Eloquent\User;

class ExternalAuthTokenParserTest extends UnitTestCase
{
    /** @var ExternalAuthTokenParser */
    private $tokenParser;

    public function testNoTokens()
    {
        $this->setUpTest('returnTrueCallback', 'returnUserCallback', 'returnUserCallback');

        $user = $this->tokenParser->getUserData('', '');
        $this->assertFalse($user);
    }

    public function testNoCompanyToken()
    {
        $this->setUpTest('returnFalseCallback', 'returnUserCallback', 'returnUserCallback');

        $user = $this->tokenParser->getUserData('', 'user_key');
        $this->assertFalse($user);
    }

    public function testNoUserToken()
    {
        $this->setUpTest('returnTrueCallback', 'returnFalseCallback', 'returnUserCallback');

        $user = $this->tokenParser->getUserData('company_key', '');
        $this->assertFalse($user);
    }

    public function testInvalidTokens()
    {
        $this->setUpTest('returnFalseCallback', 'returnFalseCallback', 'returnUserCallback');

        $user = $this->tokenParser->getUserData('company_invalid_key', 'user_invalid_key');
        $this->assertFalse($user);
    }

    public function testInvalidCompanyToken()
    {
        $this->setUpTest('returnFalseCallback', 'returnUserCallback', 'returnUserCallback');

        $user = $this->tokenParser->getUserData('company_invalid_key', 'user_key');
        $this->assertFalse($user);
    }

    public function testInvalidUserToken()
    {
        $this->setUpTest('returnTrueCallback', 'returnFalseCallback', 'returnUserCallback');

        $user = $this->tokenParser->getUserData('company_key', 'user_invalid_key');
        $this->assertFalse($user);
    }

    public function testValidTokens()
    {
        $this->setUpTest('returnTrueCallback', 'returnUserCallback', 'returnUserCallback');

        $user = $this->tokenParser->getUserData('company_key', 'user_key');
        $this->assertEquals($user->id, '1');
        $this->assertEquals($user->admin, 0);
    }

    private function setUpTest($companiesCallback, $usersCallback, $userViewCallback)
    {
        $this->tokenParser = new ExternalAuthTokenParser(
            $this->mockExternalCompanies($companiesCallback),
            $this->mockExternalUsers($usersCallback),
            $this->mockUserView($userViewCallback)
        );
    }

    public function returnFalseCallback()
    {
        return false;
    }

    public function returnTrueCallback()
    {
        return true;
    }

    public function returnUserCallback()
    {
        $user = new User();
        $user->user_id = 1;
        $user->id = 'u_1';
        $user->admin = 0;

        return $user;
    }

    private function mockExternalCompanies($returnCallback)
    {
        $repository = \Mockery::mock(ExternalCompanies::class);

        $repository->shouldReceive('where')
            ->with('api_key', \Mockery::anyOf('', 'company_key', 'company_invalid_key'))
            ->atMost()
            ->times(1)
            ->andReturnSelf();

        $repository->shouldReceive('first')
            ->atMost()
            ->times(1)
            ->andReturnUsing([$this, $returnCallback]);

        return $repository;
    }

    private function mockExternalUsers($returnCallback)
    {
        $repository = \Mockery::mock(ExternalUsers::class);

        $repository->shouldReceive('where')
            ->with('api_key', \Mockery::anyOf('', 'user_key', 'user_invalid_key'))
            ->atMost()
            ->times(1)
            ->andReturnSelf();

        $repository->shouldReceive('first')
            ->atMost()
            ->times(1)
            ->andReturnUsing([$this, $returnCallback]);

        return $repository;
    }

    private function mockUserView($returnCallback)
    {
        $repository = \Mockery::mock(User::class);

        $repository->shouldReceive('find')
            ->with('u_1')
            ->atMost()
            ->times(1)
            ->andReturnSelf();

        $repository->shouldReceive('first')
            ->atMost()
            ->times(1)
            ->andReturnUsing([$this, $returnCallback]);

        return $repository;
    }
}
