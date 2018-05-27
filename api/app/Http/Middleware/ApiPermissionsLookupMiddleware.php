<?php
namespace DentalSleepSolutions\Http\Middleware;

use Closure;
use DentalSleepSolutions\Eloquent\Models\Dental\ApiPermissionResourceGroup;
use DentalSleepSolutions\Services\ApiPermissions\ApiPermissionsLookup;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Services\Auth\Guard;
use DentalSleepSolutions\Services\Auth\JwtHelper;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Contracts\Auth\Factory as Auth;

class ApiPermissionsLookupMiddleware
{
    public const ERROR_MESSAGE = 'This section is not available for this patient. Please check the settings in the Patient Info tab.';

    /** @var Auth */
    private $auth;

    /** @var ApiPermissionsLookup */
    private $apiPermissionsLookup;

    public function __construct (Auth $auth, ApiPermissionsLookup $apiPermissionsLookup)
    {
        $this->auth = $auth;
        $this->apiPermissionsLookup = $apiPermissionsLookup;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse
     * @throws \InvalidArgumentException
     */
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
     * @throws \InvalidArgumentException
     */
    private function isRequestAuthorized(Request $request)
    {
        $route = $request->route()->uri();

        $resource = $this->apiPermissionsLookup
            ->resourceByRoute($route)
        ;

        if (!$resource) {
            return true;
        }

        $group = $this->apiPermissionsLookup
            ->resourcePermissions($resource->group_id)
        ;

        $user = $this->authRole(JwtHelper::ROLE_USER);
        if (!$user) {
            return false;
        }

        $userId = $user->getAuthIdentifier();

        $authorized = $this->isModelAuthorized($group, $userId, JwtHelper::ROLE_USER);
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

        $patient = $this->authRole(JwtHelper::ROLE_PATIENT);
        if ($patient) {
            $patientId = $patient->getAuthIdentifier();
            if (isset($patient->parent_patientid)) {
                $parentPatientId = $patient->parent_patientid;
            }
        }

        if ($patientId) {
            $patientAuthorized = $this->isModelAuthorized($group, $patientId, JwtHelper::ROLE_PATIENT);
        }

        if ($parentPatientId) {
            $parentPatientAuthorized = $this->isModelAuthorized($group, $parentPatientId, JwtHelper::ROLE_PATIENT);
        }

        if ($patientAuthorized || $parentPatientAuthorized) {
            return true;
        }

        return false;
    }

    /**
     * @param ApiPermissionResourceGroup $group
     * @param int $modelId
     * @param string $role
     * @return bool
     */
    private function isModelAuthorized(ApiPermissionResourceGroup $group, int $modelId, string $role): bool
    {
        $needsAuthorization = $group->authorize_per_user;

        if ($role === JwtHelper::ROLE_PATIENT) {
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

    /**
     * @param string $role
     * @return Authenticatable|null
     * @throws \InvalidArgumentException
     */
    private function authRole(string $role):? Authenticatable
    {
        /** @var Guard $guard */
        $guard = $this->auth->guard($role);
        /** @var Authenticatable $authenticatable */
        $authenticatable = $guard->user();
        return $authenticatable;
    }
}
