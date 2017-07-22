<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\EpworthSleepinessScale;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class EpworthSleepinessScaleRepository extends AbstractRepository
{
    public function model()
    {
        return EpworthSleepinessScale::class;
    }
}
