<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class AppointmentSummaryRepository extends AbstractRepository
{
    public function model()
    {
        return AppointmentSummary::class;
    }
}
