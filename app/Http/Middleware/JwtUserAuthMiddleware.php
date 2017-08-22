<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Exceptions\JWT\EmptyTokenException;
use DentalSleepSolutions\Exceptions\JWT\InvalidPayloadException;
use DentalSleepSolutions\Exceptions\JWT\InvalidTokenException;
use DentalSleepSolutions\Exceptions\JWT\InactiveTokenException;
use DentalSleepSolutions\Exceptions\JWT\ExpiredTokenException;
use DentalSleepSolutions\Exceptions\Auth\AuthenticatableNotFoundException;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Structs\JwtMiddlewareErrors as MiddlewareErrors;
use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class JwtUserAuthMiddleware
{
    const AUTH_HEADER = 'Authorization';
    const AUTH_HEADER_START = 'Bearer ';
    const SUDO_FIELD = 'sudo_id';
    const SUDO_REFERENCE = 'userid';

    /** @var JwtAuth */
    private $auth;

    /**
     * @param JwtAuth $auth
     */
    public function __construct(JwtAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header(self::AUTH_HEADER, '');
        $authHeaderStart = strlen(self::AUTH_HEADER_START);

        if (!substr($authHeader, 0, $authHeaderStart) !== self::AUTH_HEADER_START) {
            return $next($request);
        }

        $token = substr($authHeader, $authHeaderStart);

        if ($request->admin()) {
            $request = $this->handleSudo($request);
            return $next($request);
        }

        try {
            $this->auth->toRole(JwtAuth::ROLE_USER, $token);
        } catch (EmptyTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_MISSING, Response::HTTP_BAD_REQUEST);
        } catch (InvalidTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_INVALID, Response::HTTP_BAD_REQUEST);
        } catch (InactiveTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_INACTIVE, Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (ExpiredTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_EXPIRED, Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (InvalidPayloadException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_INVALID, Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (AuthenticatableNotFoundException $e) {
            return ApiResponse::responseError(MiddlewareErrors::USER_NOT_FOUND, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $request->setUserResolver(function () {
            $user = $this->auth
                ->guard(JwtAuth::ROLE_USER)
                ->user()
            ;
            return $user;
        });

        return $next($request);
    }

    /**
     * @param Request $request
     * @return Request
     */
    private function handleSudo(Request $request)
    {
        $sudoId = $request->input(self::SUDO_FIELD, '');

        $user = $this->auth
            ->guard(JwtAuth::ROLE_USER)
            ->once([
                self::SUDO_REFERENCE => $sudoId
            ])
        ;

        if (!$user) {
            return $request;
        }

        $request->setUserResolver(function () {
            $user = $this->auth
                ->guard(JwtAuth::ROLE_USER)
                ->user()
            ;
            return $user;
        });

        return $request;
    }
}
