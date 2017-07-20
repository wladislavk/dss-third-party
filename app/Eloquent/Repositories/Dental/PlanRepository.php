<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Plan;
use Prettus\Repository\Eloquent\BaseRepository;

class PlanRepository extends BaseRepository
{
    public function model()
    {
        return Plan::class;
    }
}
