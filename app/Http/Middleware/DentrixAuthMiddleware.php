<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Auth\DentrixAuth;
use DentalSleepSolutions\Exceptions\Auth\AuthenticatableNotFoundException;
use DentalSleepSolutions\Exceptions\JWT\EmptyTokenException;
use DentalSleepSolutions\Exceptions\JWT\InvalidTokenException;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Structs\DentrixMiddlewareErrors as MiddlewareErrors;

class DentrixAuthMiddleware
{
    const COMPANY_TOKEN_INDEX = 'api_key_company';
    const USER_TOKEN_INDEX = 'api_key_user';

    /** @var DentrixAuth */
    private $auth;

    public function __construct(DentrixAuth $auth)
    {
        $this->auth = $auth;
    }

    public function handle(Request $request, Closure $next)
    {
        $companyToken = $request->input(self::COMPANY_TOKEN_INDEX, '');
        $userToken = $request->input(self::USER_TOKEN_INDEX, '');

        try {
            $this->auth->toRole('DentrixCompany', $companyToken);
        } catch (EmptyTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::COMPANY_TOKEN_MISSING, 400);
        } catch (InvalidTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::COMPANY_TOKEN_INVALID, 422);
        }

        try {
            $this->auth->toRole('DentrixUser', $userToken);
        } catch (EmptyTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::USER_TOKEN_MISSING, 400);
        } catch (InvalidTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::USER_TOKEN_INVALID, 422);
        }

        $dentrixUser = $this->auth
            ->guard('DentrixUser')
            ->user()
        ;

        try {
            $this->auth->roRole('User', $dentrixUser->user_id);
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
}
