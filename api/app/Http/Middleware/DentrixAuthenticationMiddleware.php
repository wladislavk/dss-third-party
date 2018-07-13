<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Auth\Guard;
use DentalSleepSolutions\Services\Auth\JwtHelper;
use DentalSleepSolutions\Structs\DentrixMiddlewareErrors as MiddlewareErrors;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class DentrixAuthenticationMiddleware
{
    public const COMPANY_TOKEN_INDEX = 'api_key_company';
    public const USER_TOKEN_INDEX = 'api_key_user';
    public const ROLE_DENTRIX_COMPANY = 'dentrixCompany';
    public const ROLE_DENTRIX_USER = 'dentrixUser';
    public const DENTRIX_MODEL_KEY = 'api_key';
    public const USER_MODEL_KEY = 'user_id';

    /** @var Auth */
    private $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse
     * @throws \InvalidArgumentException
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $companyToken = $request->input(self::COMPANY_TOKEN_INDEX, '');
        if (!$companyToken) {
            return ApiResponse::responseError(MiddlewareErrors::COMPANY_TOKEN_MISSING, Response::HTTP_BAD_REQUEST);
        }
        /** @var Guard $guard */
        $guard = $this->auth->guard(self::ROLE_DENTRIX_COMPANY);
        /** @var Authenticatable $authenticatable */
        $authenticatable = $guard->validate([self::DENTRIX_MODEL_KEY => $companyToken]);
        if (!$authenticatable) {
            return ApiResponse::responseError(
                MiddlewareErrors::COMPANY_TOKEN_INVALID, Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        $userToken = $request->input(self::USER_TOKEN_INDEX, '');
        if (!$userToken) {
            return ApiResponse::responseError(MiddlewareErrors::USER_TOKEN_MISSING, Response::HTTP_BAD_REQUEST);
        }
        /** @var Guard $guard */
        $guard = $this->auth->guard(self::ROLE_DENTRIX_USER);
        /** @var Authenticatable $authenticatable */
        $authenticatable = $guard->validate([self::DENTRIX_MODEL_KEY => $userToken]);
        if (!$authenticatable) {
            return ApiResponse::responseError(
                MiddlewareErrors::USER_TOKEN_INVALID, Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        $userId = null;
        if (isset($authenticatable->{self::USER_MODEL_KEY})) {
            $userId = $authenticatable->{self::USER_MODEL_KEY};
        }
        /** @var Guard $guard */
        $guard = $this->auth->guard(JwtHelper::ROLE_USER);
        /** @var Authenticatable $authenticatable */
        $authenticatable = $guard->loginUsingId($userId);
        if (!$authenticatable) {
            return ApiResponse::responseError(
                MiddlewareErrors::USER_NOT_FOUND, Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        return $next($request);
    }
}
