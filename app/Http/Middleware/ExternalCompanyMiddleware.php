<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Helpers\ExternalAuthTokenParser;
use DentalSleepSolutions\Structs\ExternalAuthTokenErrors as AuthErrors;
use DentalSleepSolutions\Structs\ExternalCompanyMiddlewareErrors as MiddlewareErrors;
use Illuminate\Http\Request;

class ExternalCompanyMiddleware
{
    /** @var ExternalAuthTokenParser */
    private $authTokenParser;

    public function __construct(ExternalAuthTokenParser $authTokenParser)
    {
        $this->authTokenParser = $authTokenParser;
    }

    public function handle(Request $request, Closure $next)
    {
        $currentUser = $this->authTokenParser->getUserData();

        if ($currentUser) {
            return $next($request);
        }
        
        $validationError = $this->authTokenParser->validationError();

        if ($validationError === AuthErrors::COMPANY_KEY_MISSING) {
            return ApiResponse::responseError(['error' => MiddlewareErrors::COMPANY_KEY_MISSING], 400);
        }

        if ($validationError === AuthErrors::USER_KEY_MISSING) {
            return ApiResponse::responseError(['error' => MiddlewareErrors::USER_KEY_MISSING], 400);
        }

        if ($validationError === AuthErrors::COMPANY_KEY_INVALID) {
            return ApiResponse::responseError(['error' => MiddlewareErrors::COMPANY_KEY_INVALID], 422);
        }

        if ($validationError === AuthErrors::USER_KEY_INVALID) {
            return ApiResponse::responseError(['error' => MiddlewareErrors::USER_KEY_INVALID], 422);
        }

        if ($validationError === AuthErrors::USER_NOT_FOUND) {
            return ApiResponse::responseError(['error' => MiddlewareErrors::USER_NOT_FOUND], 422);
        }

        return ApiResponse::responseError(['error' => MiddlewareErrors::KEYS_INVALID], 422);
    }
}
