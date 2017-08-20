<?php

namespace Tests\Unit\Middleware;

use Closure;
use DentalSleepSolutions\Auth\JwtAuth as Auth;
use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Http\JsonResponse;
use DentalSleepSolutions\Exceptions\JWT\EmptyTokenException;
use DentalSleepSolutions\Exceptions\JWT\InvalidTokenException;
use DentalSleepSolutions\Exceptions\JWT\InactiveTokenException;
use DentalSleepSolutions\Exceptions\JWT\ExpiredTokenException;
use DentalSleepSolutions\Exceptions\JWT\InvalidPayloadException;
use DentalSleepSolutions\Exceptions\Auth\AuthenticatableNotFoundException;
use DentalSleepSolutions\Structs\JwtMiddlewareErrors as MiddlewareErrors;
use DentalSleepSolutions\Http\Middleware\JwtUserAuthMiddleware as Middleware;
use Tests\TestCases\UnitTestCase;

class JwtUserAuthMiddlewareTest extends UnitTestCase
{
    const GUARD_USER = 'guard-user';
    const VALID_USER_ID = 'u_1';
    const INVALID_USER_ID = '-';
    const REQUEST_DATA = ['sudo_as' => ''];
    const REPLACEMENT_DATA = [];

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

    public function testHandleSudoInvalidUser()
    {
        $this->request->shouldReceive('admin')
            ->once()
            ->andReturn(true)
        ;
        $this->request->shouldReceive('input')
            ->once()
            ->andReturn(self::INVALID_USER_ID)
        ;
        $this->request->shouldReceive('all')
            ->once()
            ->andReturn(self::REQUEST_DATA)
        ;
        $this->request->shouldReceive('replace')
            ->once()
            ->with(self::REPLACEMENT_DATA)
        ;
        $request = $this->middleware->handle($this->request, $this->nextClosure);

        $this->assertEquals(1, $this->closureCalls);
        $this->assertEquals($this->request, $request);
        $this->assertNull($this->userResolver);
    }

    public function testHandleSudoValidUser()
    {
        $this->request->shouldReceive('admin')
            ->once()
            ->andReturn(true)
        ;
        $this->request->shouldReceive('input')
            ->once()
            ->andReturn(self::VALID_USER_ID)
        ;
        $this->request->shouldReceive('all')
            ->once()
            ->andReturn(self::REQUEST_DATA)
        ;
        $this->request->shouldReceive('replace')
            ->once()
            ->with(self::REPLACEMENT_DATA)
        ;
        $request = $this->middleware->handle($this->request, $this->nextClosure);

        $this->assertEquals(1, $this->closureCalls);
        $this->assertEquals($this->request, $request);
        $this->assertInstanceOf(Closure::class, $this->userResolver);
        $this->assertEquals(self::GUARD_USER, $this->userResolver->__invoke());
    }

    public function testHandleNoException()
    {
        $this->auth->shouldReceive('toUser')
            ->once()
        ;
        $this->request->shouldReceive('admin')
            ->once()
        ;
        $request = $this->middleware->handle($this->request, $this->nextClosure);

        $this->assertEquals(1, $this->closureCalls);
        $this->assertEquals($this->request, $request);
        $this->assertInstanceOf(Closure::class, $this->userResolver);
        $this->assertEquals(self::GUARD_USER, $this->userResolver->__invoke());
    }

    public function testHandleEmptyTokenException()
    {
        $this->auth->shouldReceive('toUser')
            ->once()
            ->andThrow(new EmptyTokenException())
        ;
        $this->request->shouldReceive('admin')
            ->once()
        ;
        $response = $this->middleware->handle($this->request, $this->nextClosure);

        $this->assertNull($this->userResolver);
        $this->assertEquals(0, $this->closureCalls);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(MiddlewareErrors::TOKEN_MISSING, $response->getData()->message);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testHandleInvalidTokenException()
    {
        $this->auth->shouldReceive('toUser')
            ->once()
            ->andThrow(new InvalidTokenException())
        ;
        $this->request->shouldReceive('admin')
            ->once()
        ;
        $response = $this->middleware->handle($this->request, $this->nextClosure);

        $this->assertNull($this->userResolver);
        $this->assertEquals(0, $this->closureCalls);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(MiddlewareErrors::TOKEN_INVALID, $response->getData()->message);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testHandleInactiveTokenException()
    {
        $this->auth->shouldReceive('toUser')
            ->once()
            ->andThrow(new InactiveTokenException())
        ;
        $this->request->shouldReceive('admin')
            ->once()
        ;
        $response = $this->middleware->handle($this->request, $this->nextClosure);

        $this->assertNull($this->userResolver);
        $this->assertEquals(0, $this->closureCalls);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(MiddlewareErrors::TOKEN_INACTIVE, $response->getData()->message);
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function testHandleExpiredTokenException()
    {
        $this->auth->shouldReceive('toUser')
            ->once()
            ->andThrow(new ExpiredTokenException())
        ;
        $this->request->shouldReceive('admin')
            ->once()
        ;
        $response = $this->middleware->handle($this->request, $this->nextClosure);

        $this->assertNull($this->userResolver);
        $this->assertEquals(0, $this->closureCalls);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(MiddlewareErrors::TOKEN_EXPIRED, $response->getData()->message);
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function testHandleInvalidPayloadException()
    {
        $this->auth->shouldReceive('toUser')
            ->once()
            ->andThrow(new InvalidPayloadException())
        ;
        $this->request->shouldReceive('admin')
            ->once()
        ;
        $response = $this->middleware->handle($this->request, $this->nextClosure);

        $this->assertNull($this->userResolver);
        $this->assertEquals(0, $this->closureCalls);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(MiddlewareErrors::TOKEN_INVALID, $response->getData()->message);
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function testHandleAuthenticatableNotFoundException()
    {
        $this->auth->shouldReceive('toUser')
            ->once()
            ->andThrow(new AuthenticatableNotFoundException())
        ;
        $this->request->shouldReceive('admin')
            ->once()
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
        $mock->shouldReceive('guard->once')
            ->atMost(1)
            ->andReturnUsing(function (array $where) {
                if (isset($where['userid']) && $where['userid'] === self::VALID_USER_ID) {
                    return true;
                }

                return false;
            })
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
