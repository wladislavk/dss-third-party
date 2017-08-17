<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Exceptions\JWT\EmptyTokenException;
use DentalSleepSolutions\Exceptions\JWT\InvalidTokenException;
use DentalSleepSolutions\Exceptions\Auth\UserNotFoundException;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Auth\DentrixAuth;
use DentalSleepSolutions\Structs\DentrixAuthErrors as AuthErrors;
use DentalSleepSolutions\Structs\DentrixMiddlewareErrors as MiddlewareErrors;
use DentalSleepSolutions\Http\Requests\Request;

class DentrixAuthMiddleware
{
    /** @var DentrixAuth */
    private $auth;

    public function __construct(DentrixAuth $auth)
    {
        $this->auth = $auth;
    }

    public function handle(Request $request, Closure $next)
    {
        $this->auth->setRequest($request);

        try {
            $this->auth->toUser();
        } catch (EmptyTokenException $e) {
            if ($e->getMessage() === AuthErrors::COMPANY_TOKEN_MISSING) {
                return ApiResponse::responseError(MiddlewareErrors::COMPANY_TOKEN_MISSING, 400);
            }

            return ApiResponse::responseError(MiddlewareErrors::USER_TOKEN_MISSING, 400);
        } catch (InvalidTokenException $e) {
            if ($e->getMessage() === AuthErrors::COMPANY_TOKEN_INVALID) {
                return ApiResponse::responseError(MiddlewareErrors::COMPANY_TOKEN_INVALID, 422);
            }

            return ApiResponse::responseError(MiddlewareErrors::USER_TOKEN_INVALID, 422);
        } catch (UserNotFoundException $e) {
            return ApiResponse::responseError(MiddlewareErrors::USER_NOT_FOUND, 422);
        }

        $request->setUserResolver(function () {
            $user = $this->auth
                ->guard()
                ->user()
            ;
            return $user;
        });

        return $next($request);
    }
}
