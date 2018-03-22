<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\PatientSummary;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class PatientSummaryRepository extends AbstractRepository
{
    public function model()
    {
        return PatientSummary::class;
    }
}
