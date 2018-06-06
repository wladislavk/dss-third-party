<?php

namespace DentalSleepSolutions\Services\ApiPermissions;

use DentalSleepSolutions\Eloquent\Repositories\Dental\ApiPermissionResourceGroupRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ApiPermissionResourceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ApiPermissionRepository;
use DentalSleepSolutions\Eloquent\Models\Dental\ApiPermission;
use DentalSleepSolutions\Eloquent\Models\Dental\ApiPermissionResource;
use DentalSleepSolutions\Eloquent\Models\Dental\ApiPermissionResourceGroup;
use DentalSleepSolutions\Services\Auth\JwtHelper;

class ApiPermissionsLookup
{
    /** @var ApiPermissionRepository */
    private $apiPermissions;

    /** @var ApiPermissionResourceRepository */
    private $permissionResources;

    /** @var ApiPermissionResourceGroupRepository */
    private $permissionResourceGroups;

    /**
     * @param ApiPermissionRepository              $apiPermissions
     * @param ApiPermissionResourceRepository      $permissionResources
     * @param ApiPermissionResourceGroupRepository $permissionResourceGroups
     */
    public function __construct(
        ApiPermissionRepository $apiPermissions,
        ApiPermissionResourceRepository $permissionResources,
        ApiPermissionResourceGroupRepository $permissionResourceGroups
    )
    {
        $this->apiPermissions = $apiPermissions;
        $this->permissionResources = $permissionResources;
        $this->permissionResourceGroups = $permissionResourceGroups;
    }

    /**
     * @param string $route
     * @return ApiPermissionResource|null
     */
    public function resourceByRoute($route)
    {
        $resource = $this->permissionResources
            ->findWhere([
                'route' => $route,
            ])
            ->first()
        ;
        return $resource;
    }

    /**
     * @param int $groupId
     * @return ApiPermissionResourceGroup|null
     */
    public function resourcePermissions($groupId)
    {
        $group = $this->permissionResourceGroups
            ->find($groupId)
        ;
        return $group;
    }

    /**
     * @param int $groupId
     * @param int $modelId
     * @param string $role
     * @return ApiPermission|null
     */
    public function modelPermissions($groupId, $modelId, $role)
    {
        $doctorId = 0;
        $patientId = 0;

        if ($role === JwtHelper::ROLE_USER) {
            $doctorId = $modelId;
        }

        if ($role === JwtHelper::ROLE_PATIENT) {
            $patientId = $modelId;
        }

        $permissions = $this->apiPermissions
            ->findWhere([
                'group_id' => $groupId,
                'doc_id' => $doctorId,
                'patient_id' => $patientId,
            ])
            ->first()
        ;
        return $permissions;
    }
}
