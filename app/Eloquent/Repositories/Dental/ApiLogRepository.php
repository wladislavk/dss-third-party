<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ApiLog;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ApiLogRepository extends AbstractRepository
{
    public function model()
    {
        return ApiLog::class;
    }
}
