<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Calendar;
use Prettus\Repository\Eloquent\BaseRepository;

class CalendarRepository extends BaseRepository
{
    public function model()
    {
        return Calendar::class;
    }
}
