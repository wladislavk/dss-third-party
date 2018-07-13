<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Exceptions\JWT\ExpiredTokenException;
use DentalSleepSolutions\Exceptions\JWT\InactiveTokenException;
use DentalSleepSolutions\Exceptions\JWT\InvalidPayloadException;
use DentalSleepSolutions\Exceptions\JWT\InvalidTokenException;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Services\Auth\JwtHelper;
use DentalSleepSolutions\Structs\JwtMiddlewareErrors as MiddlewareErrors;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtAuthenticationMiddleware
{
    public const AUTH_HEADER = 'Authorization';
    public const AUTH_HEADER_START = 'Bearer ';

    /** @var Auth */
    private $auth;

    /** @var JwtHelper */
    private $jwtHelper;

    /**
     * @param Auth $auth
     * @param JwtHelper $jwtHelper
     */
    public function __construct(
        Auth $auth,
        JwtHelper $jwtHelper
    ) {
        $this->auth = $auth;
        $this->jwtHelper = $jwtHelper;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse
     * @throws \InvalidArgumentException
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $authHeader = $request->header(self::AUTH_HEADER, '');
        $authHeaderStart = strlen(self::AUTH_HEADER_START);
        if (substr($authHeader, 0, $authHeaderStart) !== self::AUTH_HEADER_START) {
             return ApiResponse::responseError(MiddlewareErrors::TOKEN_MISSING, Response::HTTP_BAD_REQUEST);
        }
        $token = substr($authHeader, $authHeaderStart);
        try {
            $claims = $this->jwtHelper->parseToken($token);
        } catch (TokenInvalidException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_INVALID, Response::HTTP_BAD_REQUEST);
        }
        try {
            $this->jwtHelper->validateClaims($claims, [], ['id', 'role']);
        } catch (InvalidTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_INVALID, Response::HTTP_BAD_REQUEST);
        } catch (InactiveTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_INACTIVE, Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (ExpiredTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_EXPIRED, Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (InvalidPayloadException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_INVALID, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $guardRole = strtolower($claims[JwtHelper::CLAIM_ROLE_INDEX]);
        $guardId = (int)$claims[JwtHelper::CLAIM_ID_INDEX];
        /** @var Guard $guard */
        $guard = $this->auth->guard($guardRole);
        /** @var Authenticatable $authenticatable */
        $authenticatable = $guard->loginUsingId($guardId);
        if (!$authenticatable) {
            return ApiResponse::responseError(MiddlewareErrors::USER_NOT_FOUND, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return $next($request);
    }
}
