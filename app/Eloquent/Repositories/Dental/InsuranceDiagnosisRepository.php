<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\InsuranceDiagnosis;
use Prettus\Repository\Eloquent\BaseRepository;

class InsuranceDiagnosisRepository extends BaseRepository
{
    public function model()
    {
        return InsuranceDiagnosis::class;
    }
}
