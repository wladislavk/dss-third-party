<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Eloquent\Models\Dental\ApiPermissionResourceGroup;
use DentalSleepSolutions\Services\ApiPermissions\ApiPermissionsLookup;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Facades\ApiResponse;
use Illuminate\Http\Response;

class ApiPermissionsLookupMiddleware
{
    const ERROR_MESSAGE = 'This section is not available for this patient. Please check the settings in the Patient Info tab.';

    /** @var ApiPermissionsLookup */
    protected $apiPermissionsLookup;

    public function __construct (ApiPermissionsLookup $apiPermissionsLookup)
    {
        $this->apiPermissionsLookup = $apiPermissionsLookup;
    }

    public function handle(Request $request, Closure $next)
    {
        $authorized = $this->isRequestAuthorized($request);

        if ($authorized) {
            return $next($request);
        }

        return ApiResponse::responseError([
            'error' => self::ERROR_MESSAGE,
        ], Response::HTTP_FORBIDDEN);
    }

    /**
     * @todo Refactor into helper
     */
    /**
     * @param Request $request
     * @return bool
     */
    private function isRequestAuthorized(Request $request)
    {
        $route = $request
            ->route()
            ->getUri()
        ;

        $resource = $this->apiPermissionsLookup
            ->resourceByRoute($route)
        ;

        if (!$resource) {
            return true;
        }

        $group = $this->apiPermissionsLookup
            ->resourcePermissions($resource->group_id)
        ;

        if (!$request->user()) {
            return false;
        }

        $userId = $request->user()->userid;

        $authorized = $this->isModelAuthorized($group, $userId, JwtAuth::ROLE_USER);
        if (!$authorized) {
            return false;
        }

        if (!$group->authorize_per_patient) {
            return true;
        }

        $patientId = 0;
        $parentPatientId = 0;
        $patientAuthorized = false;
        $parentPatientAuthorized = false;

        if ($request->patient()) {
            $patientId = $request->patient()->patientid;
            $parentPatientId = $request->patient()->parent_patientid;
        }

        if ($patientId) {
            $patientAuthorized = $this->isModelAuthorized($group, $patientId, JwtAuth::ROLE_PATIENT);
        }

        if ($parentPatientId) {
            $parentPatientAuthorized = $this->isModelAuthorized($group, $parentPatientId, JwtAuth::ROLE_PATIENT);
        }

        if ($patientAuthorized || $parentPatientAuthorized) {
            return true;
        }

        return false;
    }

    /**
     * @param ApiPermissionResourceGroup $group
     * @param int                        $modelId
     * @param string                     $role
     * @return bool
     */
    private function isModelAuthorized(ApiPermissionResourceGroup $group, $modelId, $role)
    {
        $needsAuthorization = $group->authorize_per_user;

        if ($role === JwtAuth::ROLE_PATIENT) {
            $needsAuthorization = $group->authorize_per_patient;
        }

        if (!$needsAuthorization) {
            return true;
        }

        $permissions = $this->apiPermissionsLookup
            ->modelPermissions($group->getKey(), $modelId, $role)
        ;

        if ($permissions) {
            return true;
        }

        return false;
    }
}
