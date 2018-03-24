<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\PlanText;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class PlanTextRepository extends AbstractRepository
{
    public function model()
    {
        return PlanText::class;
    }
}
