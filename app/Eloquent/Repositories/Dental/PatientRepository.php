<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use Prettus\Repository\Eloquent\BaseRepository;

class PatientRepository extends BaseRepository
{
    public function model()
    {
        return Patient::class;
    }
}
