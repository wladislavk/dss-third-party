<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ApiPermissionResource;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ApiPermissionResourceRepository extends AbstractRepository
{
    public function model()
    {
        return ApiPermissionResource::class;
    }
}
