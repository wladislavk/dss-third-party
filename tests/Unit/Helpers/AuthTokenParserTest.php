<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\User;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;
use Tymon\JWTAuth\JWTAuth;
use DentalSleepSolutions\Helpers\AuthTokenParser;
use Illuminate\Support\Facades\App;

class AuthTokenParserTest extends UnitTestCase
{
    /** @var JWTAuth */
    private $auth;

    /** @var AuthTokenParser */
    private $tokenParser;

    public function testNoToken()
    {
        $this->setUpTest('', 'returnUserCallback');

        $user = $this->tokenParser->getUserData();
        $admin = $this->tokenParser->getAdminData();

        $this->assertFalse($user);
        $this->assertFalse($admin);
    }

    public function testUserToken()
    {
        $this->setUpTest('u_1', 'returnUserCallback');

        $user = $this->tokenParser->getUserData();
        $admin = $this->tokenParser->getAdminData();

        $this->assertEquals($user->id, '1');
        $this->assertEquals($user->admin, 0);
        $this->assertFalse($admin);
    }

    public function testAdminToken()
    {
        $this->setUpTest('a_1', 'returnAdminCallback');

        $user = $this->tokenParser->getUserData();
        $admin = $this->tokenParser->getAdminData();

        $this->assertFalse($user);
        $this->assertEquals($admin->id, '1');
        $this->assertEquals($admin->admin, 1);
    }

    public function testAdminUserToken()
    {
        $this->setUpTest('a_1|u_1', 'returnAdminUserCallback');

        $user = $this->tokenParser->getUserData();
        $admin = $this->tokenParser->getAdminData();

        $this->assertEquals($user->id, '1');
        $this->assertEquals($user->admin, 0);
        $this->assertEquals($admin->id, '1');
        $this->assertEquals($admin->admin, 1);
    }

    public function testUserAdminToken()
    {
        $this->setUpTest('a_1|u_1', 'returnUserAdminCallback');

        $user = $this->tokenParser->getUserData();
        $admin = $this->tokenParser->getAdminData();

        $this->assertEquals($user->id, '1');
        $this->assertEquals($user->admin, 0);
        $this->assertEquals($admin->id, '1');
        $this->assertEquals($admin->admin, 1);
    }

    public function testUserUserToken()
    {
        $this->setUpTest('u_1|u_2', 'returnUserCallback');

        $user = $this->tokenParser->getUserData();
        $admin = $this->tokenParser->getAdminData();

        $this->assertEquals($user->id, '1');
        $this->assertEquals($user->admin, 0);
        $this->assertFalse($admin);
    }

    public function testAdminAdminToken()
    {
        $this->setUpTest('a_1|a_2', 'returnAdminCallback');

        $user = $this->tokenParser->getUserData();
        $admin = $this->tokenParser->getAdminData();

        $this->assertFalse($user);
        $this->assertEquals($admin->id, '1');
        $this->assertEquals($admin->admin, 1);
    }

    private function setUpTest($mockToken, $returnCallback)
    {
        $this->auth = $this->mockJWTAuth($mockToken, $returnCallback);
        $this->tokenParser = new AuthTokenParser($this->auth);
    }

    public function returnUserCallback()
    {
        $user = new User();
        $user->id = 'u_1';
        $user->admin = 0;

        return $user;
    }

    public function returnAdminCallback()
    {
        $user = new User();
        $user->id = 'a_1';
        $user->admin = 1;

        return $user;
    }

    public function returnAdminUserCallback()
    {
        return [$this->returnAdminCallback(), $this->returnUserCallback()];
    }

    public function returnUserAdminCallback()
    {
        return [$this->returnUserCallback(), $this->returnAdminCallback()];
    }

    private function mockJWTAuth($mockToken, $returnCallback)
    {
        $auth = \Mockery::mock(JWTAuth::class);

        $auth->shouldReceive('getToken')
            ->twice()
            ->andReturn($mockToken);

        $auth->shouldReceive('toUser')
            ->atMost()
            ->times(2)
            ->andReturnUsing([$this, $returnCallback]);

        return $auth;
    }
}
