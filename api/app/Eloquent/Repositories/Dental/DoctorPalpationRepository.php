<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\DoctorPalpation;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class DoctorPalpationRepository extends AbstractRepository
{
    public function model()
    {
        return DoctorPalpation::class;
    }
}
