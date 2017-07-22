<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Calendar;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class CalendarRepository extends AbstractRepository
{
    public function model()
    {
        return Calendar::class;
    }
}
