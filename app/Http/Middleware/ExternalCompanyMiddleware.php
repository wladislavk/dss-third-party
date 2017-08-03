<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Helpers\ExternalAuthTokenParser;
use DentalSleepSolutions\Structs\ExternalAuthTokenErrors as AuthErrors;
use DentalSleepSolutions\Structs\ExternalCompanyMiddlewareErrors as MiddlewareErrors;
use Illuminate\Http\Request;

class ExternalCompanyMiddleware
{
    const COMPANY_KEY_MISSING = 'api_key_company_not_provided';
    const USER_KEY_MISSING = 'api_key_user_not_provided';
    const COMPANY_KEY_INVALID = 'api_key_company_invalid';
    const USER_KEY_INVALID = 'api_key_user_invalid';
    const KEYS_INVALID = 'api_keys_invalid';

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
