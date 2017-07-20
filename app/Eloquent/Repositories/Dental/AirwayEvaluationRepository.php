<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\AirwayEvaluation;
use Prettus\Repository\Eloquent\BaseRepository;

class AirwayEvaluationRepository extends BaseRepository
{
    public function model()
    {
        return AirwayEvaluation::class;
    }
}
