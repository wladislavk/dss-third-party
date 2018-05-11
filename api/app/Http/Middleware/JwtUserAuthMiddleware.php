<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Exceptions\Auth\AuthenticatableNotFoundException;
use DentalSleepSolutions\Exceptions\HttpMalformedHeaderException;
use DentalSleepSolutions\Exceptions\JWT\ExpiredTokenException;
use DentalSleepSolutions\Exceptions\JWT\InactiveTokenException;
use DentalSleepSolutions\Exceptions\JWT\InvalidPayloadException;
use DentalSleepSolutions\Exceptions\JWT\InvalidTokenException;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Structs\JwtMiddlewareErrors as MiddlewareErrors;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class JwtUserAuthMiddleware extends AbstractJwtAuthMiddleware
{
    /** @var string */
    protected $role = JwtAuth::ROLE_USER;

    /** @var string */
    protected $sudoField = self::USER_SUDO_ID;

    /** @var string */
    protected $sudoReference = self::USER_MODEL_ID;

    /** @var bool */
    protected $fallsThrough = false;

    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $this->getAuthToken($request);
        } catch (HttpMalformedHeaderException $e) {
            return ApiResponse::responseError(MiddlewareErrors::TOKEN_MISSING, Response::HTTP_BAD_REQUEST);
        }

        if ($request->admin()) {
            $request = $this->handleSudo($request);
            return $next($request);
        }

        try {
            $this->auth->toRole(JwtAuth::ROLE_USER, $token);
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

        $request->setUserResolver(function () use ($request) {
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
    protected function handleSudo(Request $request)
    {
        $sudoId = $request->input($this->sudoField, '');

        $user = $this->auth
            ->guard(JwtAuth::ROLE_USER)
            ->once([
                $this->sudoReference => $sudoId
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
