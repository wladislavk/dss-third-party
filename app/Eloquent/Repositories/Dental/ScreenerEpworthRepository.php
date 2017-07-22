<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ScreenerEpworth;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ScreenerEpworthRepository extends AbstractRepository
{
    public function model()
    {
        return ScreenerEpworth::class;
    }
}
