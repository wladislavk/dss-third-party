<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Screener;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ScreenerRepository extends AbstractRepository
{
    public function model()
    {
        return Screener::class;
    }
}
