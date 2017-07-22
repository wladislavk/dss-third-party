<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalCompanyRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ExternalUserRepository;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\StaticClasses\ApiResponse;

class ExternalCompanyMiddleware
{
    /** @var ExternalCompanyRepository */
    protected $externalCompanyRepository;

    /** @var ExternalUserRepository */
    protected $externalUserRepository;

    public function __construct(
        ExternalCompanyRepository $externalCompanyRepository,
        ExternalUserRepository $externalUserRepository
    ) {
        $this->externalCompanyRepository = $externalCompanyRepository;
        $this->externalUserRepository = $externalUserRepository;
    }

    public function handle(Request $request, Closure $next)
    {
        $companyKey = $request->input('api_key_company');
        $userKey = $request->input('api_key_user');

        if (!strlen($companyKey)) {
            return ApiResponse::responseError(['error' => 'api_key_company_not_provided'], 400);
        }

        if (!strlen($userKey)) {
            return ApiResponse::responseError(['error' => 'api_key_user_not_provided'], 400);
        }

        $externalCompany = $this->externalCompanyRepository->findByApiKey($companyKey);

        if (!$externalCompany) {
            return ApiResponse::responseError(['error' => 'api_key_company_invalid'], 422);
        }

        $externalUser = $this->externalUserRepository->findByApiKey($userKey);

        if (!$externalUser || !$externalUser->user() || !count($externalUser->user())) {
            return ApiResponse::responseError(['error' => 'api_key_user_invalid'], 422);
        }

        return $next($request);
    }
}
