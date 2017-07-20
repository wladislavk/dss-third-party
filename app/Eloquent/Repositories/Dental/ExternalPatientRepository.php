<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalPatient;
use Prettus\Repository\Eloquent\BaseRepository;

class ExternalPatientRepository extends BaseRepository
{
    public function model()
    {
        return ExternalPatient::class;
    }
}
