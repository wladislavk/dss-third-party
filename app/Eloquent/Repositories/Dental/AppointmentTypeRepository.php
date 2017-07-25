<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentType;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class AppointmentTypeRepository extends AbstractRepository
{
    public function model()
    {
        return AppointmentType::class;
    }
}
