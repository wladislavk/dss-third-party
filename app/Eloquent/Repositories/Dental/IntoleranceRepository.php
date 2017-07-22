<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Intolerance;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class IntoleranceRepository extends AbstractRepository
{
    public function model()
    {
        return Intolerance::class;
    }
}
