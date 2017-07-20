<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Screener;
use Prettus\Repository\Eloquent\BaseRepository;

class ScreenerRepository extends BaseRepository
{
    public function model()
    {
        return Screener::class;
    }
}
