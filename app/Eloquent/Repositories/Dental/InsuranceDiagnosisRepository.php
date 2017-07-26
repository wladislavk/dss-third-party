<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\InsuranceDiagnosis;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class InsuranceDiagnosisRepository extends AbstractRepository
{
    public function model()
    {
        return InsuranceDiagnosis::class;
    }
}
