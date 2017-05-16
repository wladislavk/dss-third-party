<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Contracts\Repositories\ExternalCompanies;
use DentalSleepSolutions\Contracts\Repositories\ExternalUsers;

class ExternalCompanyMiddleware
{
    public function handle($request, Closure $next)
    {
        $companyKey = $request->input('api_company_key');
        $userKey = $request->input('api_user_key');

        if (!strlen($companyKey)) {
            return ApiResponse::json(['error' => 'api_company_key_not_provided', 400]);
        }

        if (!strlen($userKey)) {
            return ApiResponse::json(['error' => 'api_user_key_not_provided', 400]);
        }

        $companyResource = app()->make(ExternalCompanies::class);
        $companyResource->where('api_key', $companyKey)->firstOrFail();

        $userResource = app()->make(ExternalUsers::class);
        $userResource->where('api_key', $userKey)->user()->firstOrFail();

        return $next($request);
    }
}
