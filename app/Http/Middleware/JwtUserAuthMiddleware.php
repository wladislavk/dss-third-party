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

class JwtUserAuthMiddleware
{
    const AUTH_HEADER_START = 'Bearer ';
    const SUDO_FIELD = 'sudo_id';

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
        $authHeader = $request->header('Authorization', '');
        $authHeaderStart = strlen(self::AUTH_HEADER_START);

        if (!substr($authHeader, 0, $authHeaderStart) !== 'Bearer ') {
            return $next($request);
        }

        $token = substr($authHeader, $authHeaderStart);

        if ($request->admin()) {
            $request = $this->handleSudo($request);
            return $next($request);
        }

        try {
            $this->auth->toRole('User', $token);
        } catch (EmptyTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_MISSING, 400);
        } catch (InvalidTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_INVALID, 400);
        } catch (InactiveTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_INACTIVE, 422);
        } catch (ExpiredTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_EXPIRED, 422);
        } catch (InvalidPayloadException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_INVALID, 422);
        } catch (AuthenticatableNotFoundException $e) {
            return ApiResponse::responseError(MiddlewareErrors::USER_NOT_FOUND, 422);
        }

        $request->setUserResolver(function () {
            $user = $this->auth
                ->guard('User')
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
            ->guard('User')
            ->once([
                'userid' => $sudoId
            ])
        ;

        if (!$user) {
            return $request;
        }

        $request->setUserResolver(function () {
            $user = $this->auth
                ->guard('User')
                ->user()
            ;
            return $user;
        });

        return $request;
    }
}
