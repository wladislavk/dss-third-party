<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentType;
use Prettus\Repository\Eloquent\BaseRepository;

class AppointmentTypeRepository extends BaseRepository
{
    public function model()
    {
        return AppointmentType::class;
    }
}
