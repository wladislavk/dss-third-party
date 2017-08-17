<?php

namespace Tests\Unit\Middleware;

use Closure;
use DentalSleepSolutions\Auth\JwtAuth as Auth;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Exceptions\JwtException;
use DentalSleepSolutions\Exceptions\AuthException;
use DentalSleepSolutions\Http\Middleware\JwtAdminAuthMiddleware as Middleware;
use Tests\TestCases\UnitTestCase;

class JwtAdminAuthMiddlewareTest extends UnitTestCase
{
    const GUARD_USER = 'guard-user';

    /** @var Auth */
    private $auth;

    /** @var Middleware */
    private $middleware;

    /** @var Request */
    private $request;

    /** @var Closure */
    private $nextClosure;

    /** @var int */
    private $closureCalls;

    /** @var Closure */
    private $adminResolver;

    public function setUp()
    {
        parent::setUp();

        $this->closureCalls = 0;
        $this->adminResolver = null;
        $this->request = $this->mockRequest();
        $this->nextClosure = $this->mockNextClosure();
        $this->auth = $this->mockAuth();
        $this->middleware = new Middleware($this->auth);
    }

    public function testHandleNoException()
    {
        $this->auth->shouldReceive('toAdmin')
            ->once()
        ;
        $request = $this->middleware->handle($this->request, $this->nextClosure);

        $this->assertEquals(1, $this->closureCalls);
        $this->assertEquals($this->request, $request);
        $this->assertInstanceOf(Closure::class, $this->adminResolver);
        $this->assertEquals(self::GUARD_USER, $this->adminResolver->__invoke());
    }

    public function testHandleJwtException()
    {
        $this->auth->shouldReceive('toAdmin')
            ->once()
            ->andThrow(new JwtException())
        ;
        $request = $this->middleware->handle($this->request, $this->nextClosure);

        $this->assertEquals(1, $this->closureCalls);
        $this->assertEquals($this->request, $request);
        $this->assertInstanceOf(Closure::class, $this->adminResolver);
        $this->assertEquals(self::GUARD_USER, $this->adminResolver->__invoke());
    }

    public function testHandleAuthException()
    {
        $this->auth->shouldReceive('toAdmin')
            ->once()
            ->andThrow(new AuthException())
        ;
        $request = $this->middleware->handle($this->request, $this->nextClosure);

        $this->assertEquals(1, $this->closureCalls);
        $this->assertEquals($this->request, $request);
        $this->assertInstanceOf(Closure::class, $this->adminResolver);
        $this->assertEquals(self::GUARD_USER, $this->adminResolver->__invoke());
    }

    private function mockAuth()
    {
        $mock = \Mockery::mock(Auth::class);
        $mock->shouldReceive('setRequest')
            ->once()
        ;
        $mock->shouldReceive('guard->user')
            ->atMost(1)
            ->andReturn(self::GUARD_USER)
        ;

        return $mock;
    }

    private function mockRequest()
    {
        $mock = \Mockery::mock(Request::class);
        $mock->shouldReceive('setAdminResolver')
            ->atMost(1)
            ->andReturnUsing(function (Closure $closure) {
                $this->adminResolver = $closure;
            })
        ;
        return $mock;
    }

    private function mockNextClosure()
    {
        $closure = function (Request $request) {
            $this->closureCalls++;
            return $request;
        };

        return $closure;
    }
}
