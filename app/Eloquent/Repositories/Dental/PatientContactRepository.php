<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\PatientContact;
use Prettus\Repository\Eloquent\BaseRepository;

class PatientContactRepository extends BaseRepository
{
    public function model()
    {
        return PatientContact::class;
    }
}
