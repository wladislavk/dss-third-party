<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\EpworthSleepinessScale;
use Prettus\Repository\Eloquent\BaseRepository;

class EpworthSleepinessScaleRepository extends BaseRepository
{
    public function model()
    {
        return EpworthSleepinessScale::class;
    }
}
