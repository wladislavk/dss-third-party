<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Plan;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class PlanRepository extends AbstractRepository
{
    public function model()
    {
        return Plan::class;
    }
}
