<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ApiPermissionResourceGroup;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ApiPermissionResourceGroupRepository extends AbstractRepository
{
    public function model()
    {
        return ApiPermissionResourceGroup::class;
    }
}
