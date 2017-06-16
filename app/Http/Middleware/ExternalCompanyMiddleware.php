<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Repositories\ExternalCompanies;
use DentalSleepSolutions\Contracts\Repositories\ExternalUsers;

class ExternalCompanyMiddleware
{
    /** @var ExternalCompanies */
    protected $externalCompaniesRepository;

    /** @var ExternalUsers */
    protected $externalUsersRepository;

    public function __construct (ExternalCompanies $externalCompanies, ExternalUsers $externalUsers)
    {
        $this->externalCompaniesRepository = $externalCompanies;
        $this->externalUsersRepository = $externalUsers;
    }

    public function handle($request, Closure $next)
    {
        $companyKey = $request->input('api_key_company');
        $userKey = $request->input('api_key_user');

        if (!strlen($companyKey)) {
            return ApiResponse::responseError(['error' => 'api_key_company_not_provided'], 400);
        }

        if (!strlen($userKey)) {
            return ApiResponse::responseError(['error' => 'api_key_user_not_provided'], 400);
        }

        $externalCompany = $this->externalCompaniesRepository->where('api_key', $companyKey)->first();

        if (!$externalCompany) {
            return ApiResponse::responseError(['error' => 'api_key_company_invalid'], 422);
        }

        $externalUser = $this->externalUsersRepository->where('api_key', $userKey)->first();

        if (!$externalUser || !$externalUser->user() || !count($externalUser->user())) {
            return ApiResponse::responseError(['error' => 'api_key_user_invalid'], 422);
        }

        return $next($request);
    }
}
