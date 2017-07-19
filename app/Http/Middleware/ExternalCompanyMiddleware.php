<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Helpers\ExternalAuthTokenParser as TokenParser;

class ExternalCompanyMiddleware
{
    const COMPANY_KEY_MISSING = 'api_key_company_not_provided';
    const USER_KEY_MISSING = 'api_key_user_not_provided';
    const COMPANY_KEY_INVALID = 'api_key_company_invalid';
    const USER_KEY_INVALID = 'api_key_user_invalid';
    const KEYS_INVALID = 'api_keys_invalid';

    /** @var TokenParser */
    private $tokenParser;

    public function __construct (TokenParser $tokenParser)
    {
        $this->tokenParser = $tokenParser;
    }

    public function handle($request, Closure $next)
    {
        $currentUser = $this->tokenParser->getUserData(
            $request->input('api_key_company', ''), $request->input('api_key_user', '')
        );

        if ($currentUser) {
            $request->attributes->set('currentUser', $currentUser);
            return $next($request);
        }

        if ($this->tokenParser->getError() === TokenParser::COMPANY_KEY_MISSING) {
            return ApiResponse::responseError(['error' => self::COMPANY_KEY_MISSING], 400);
        }

        if ($this->tokenParser->getError() === TokenParser::USER_KEY_MISSING) {
            return ApiResponse::responseError(['error' => self::USER_KEY_MISSING], 400);
        }

        if ($this->tokenParser->getError() === TokenParser::COMPANY_KEY_INVALID) {
            return ApiResponse::responseError(['error' => self::COMPANY_KEY_INVALID], 422);
        }

        if ($this->tokenParser->getError() === TokenParser::USER_KEY_INVALID) {
            return ApiResponse::responseError(['error' => self::USER_KEY_INVALID], 422);
        }

        return ApiResponse::responseError(['error' => self::KEYS_INVALID], 422);
    }
}
