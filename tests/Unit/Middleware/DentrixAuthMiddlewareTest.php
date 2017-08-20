<?php

namespace Tests\Unit\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use DentalSleepSolutions\Auth\DentrixAuth as Auth;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Exceptions\JWT\EmptyTokenException;
use DentalSleepSolutions\Exceptions\JWT\InvalidTokenException;
use DentalSleepSolutions\Exceptions\Auth\AuthenticatableNotFoundException;
use DentalSleepSolutions\Structs\DentrixAuthErrors as AuthErrors;
use DentalSleepSolutions\Structs\DentrixMiddlewareErrors as MiddlewareErrors;
use DentalSleepSolutions\Http\Middleware\DentrixAuthMiddleware as Middleware;
use Tests\TestCases\UnitTestCase;

class DentrixAuthMiddlewareTest extends UnitTestCase
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
    private $userResolver;

    public function setUp()
    {
        parent::setUp();

        $this->closureCalls = 0;
        $this->userResolver = null;
        $this->request = $this->mockRequest();
        $this->nextClosure = $this->mockNextClosure();
        $this->auth = $this->mockAuth();
        $this->middleware = new Middleware($this->auth);
    }

    public function testHandleNoException()
    {
        $this->auth->shouldReceive('toUser')
            ->once()
        ;
        $request = $this->middleware->handle($this->request, $this->nextClosure);

        $this->assertEquals(1, $this->closureCalls);
        $this->assertEquals($this->request, $request);
        $this->assertInstanceOf(Closure::class, $this->userResolver);
        $this->assertEquals(self::GUARD_USER, $this->userResolver->__invoke());
    }

    public function testHandleCompanyEmptyTokenException()
    {
        $this->auth->shouldReceive('toUser')
            ->once()
            ->andThrow(new EmptyTokenException(AuthErrors::COMPANY_TOKEN_MISSING))
        ;
        $response = $this->middleware->handle($this->request, $this->nextClosure);

        $this->assertNull($this->userResolver);
        $this->assertEquals(0, $this->closureCalls);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(MiddlewareErrors::COMPANY_TOKEN_MISSING, $response->getData()->message);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testHandleUserEmptyTokenException()
    {
        $this->auth->shouldReceive('toUser')
            ->once()
            ->andThrow(new EmptyTokenException())
        ;
        $response = $this->middleware->handle($this->request, $this->nextClosure);

        $this->assertNull($this->userResolver);
        $this->assertEquals(0, $this->closureCalls);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(MiddlewareErrors::USER_TOKEN_MISSING, $response->getData()->message);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testHandleCompanyInvalidTokenException()
    {
        $this->auth->shouldReceive('toUser')
            ->once()
            ->andThrow(new InvalidTokenException(AuthErrors::COMPANY_TOKEN_INVALID))
        ;
        $response = $this->middleware->handle($this->request, $this->nextClosure);

        $this->assertNull($this->userResolver);
        $this->assertEquals(0, $this->closureCalls);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(MiddlewareErrors::COMPANY_TOKEN_INVALID, $response->getData()->message);
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function testHandleUserInvalidTokenException()
    {
        $this->auth->shouldReceive('toUser')
            ->once()
            ->andThrow(new InvalidTokenException())
        ;
        $response = $this->middleware->handle($this->request, $this->nextClosure);

        $this->assertNull($this->userResolver);
        $this->assertEquals(0, $this->closureCalls);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(MiddlewareErrors::USER_TOKEN_INVALID, $response->getData()->message);
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function testHandleUserNotFound()
    {
        $this->auth->shouldReceive('toUser')
            ->once()
            ->andThrow(new AuthenticatableNotFoundException())
        ;
        $response = $this->middleware->handle($this->request, $this->nextClosure);

        $this->assertNull($this->userResolver);
        $this->assertEquals(0, $this->closureCalls);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(MiddlewareErrors::USER_NOT_FOUND, $response->getData()->message);
        $this->assertEquals(422, $response->getStatusCode());
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
        $mock->shouldReceive('setUserResolver')
            ->atMost(1)
            ->andReturnUsing(function (Closure $closure) {
                $this->userResolver = $closure;
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
