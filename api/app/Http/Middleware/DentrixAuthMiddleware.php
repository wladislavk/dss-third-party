<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Auth\DentrixAuth;
use DentalSleepSolutions\Exceptions\Auth\AuthenticatableNotFoundException;
use DentalSleepSolutions\Exceptions\JWT\EmptyTokenException;
use DentalSleepSolutions\Exceptions\JWT\InvalidTokenException;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Structs\DentrixMiddlewareErrors as MiddlewareErrors;
use Illuminate\Http\Response;

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

    /**
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws EmptyTokenException
     * @throws InvalidTokenException
     */
    public function handle(Request $request, Closure $next)
    {
        $companyToken = $request->input(self::COMPANY_TOKEN_INDEX, '');
        $userToken = $request->input(self::USER_TOKEN_INDEX, '');

        try {
            $this->auth->toRole(DentrixAuth::ROLE_DENTRIX_COMPANY, $companyToken);
        } catch (EmptyTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::COMPANY_TOKEN_MISSING, Response::HTTP_BAD_REQUEST);
        } catch (AuthenticatableNotFoundException $e) {
            return ApiResponse::responseError(
                MiddlewareErrors::COMPANY_TOKEN_INVALID, Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $this->auth->toRole(DentrixAuth::ROLE_DENTRIX_USER, $userToken);
        } catch (EmptyTokenException $e) {
            return ApiResponse::responseError(MiddlewareErrors::USER_TOKEN_MISSING, Response::HTTP_BAD_REQUEST);
        } catch (AuthenticatableNotFoundException $e) {
            return ApiResponse::responseError(MiddlewareErrors::USER_TOKEN_INVALID, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $dentrixUser = $this->auth
            ->guard(DentrixAuth::ROLE_DENTRIX_USER)
            ->user()
        ;

        try {
            $this->auth->toRole(DentrixAuth::ROLE_USER, $dentrixUser->user_id);
        } catch (AuthenticatableNotFoundException $e) {
            return ApiResponse::responseError(MiddlewareErrors::USER_NOT_FOUND, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $request->setUserResolver(function () {
            $user = $this->auth
                ->guard(DentrixAuth::ROLE_USER)
                ->user()
            ;
            return $user;
        });

        return $next($request);
    }
}
