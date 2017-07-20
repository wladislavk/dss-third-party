<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\PatientInsurance;
use Prettus\Repository\Eloquent\BaseRepository;

class PatientInsuranceRepository extends BaseRepository
{
    public function model()
    {
        return PatientInsurance::class;
    }
}
