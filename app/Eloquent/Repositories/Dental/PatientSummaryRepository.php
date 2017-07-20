<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\PatientSummary;
use Prettus\Repository\Eloquent\BaseRepository;

class PatientSummaryRepository extends BaseRepository
{
    public function model()
    {
        return PatientSummary::class;
    }
}
