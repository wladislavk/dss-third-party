<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ScreenerEpworth;
use Prettus\Repository\Eloquent\BaseRepository;

class ScreenerEpworthRepository extends BaseRepository
{
    public function model()
    {
        return ScreenerEpworth::class;
    }
}
