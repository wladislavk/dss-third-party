<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\AirwayEvaluation;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class AirwayEvaluationRepository extends AbstractRepository
{
    public function model()
    {
        return AirwayEvaluation::class;
    }
}
