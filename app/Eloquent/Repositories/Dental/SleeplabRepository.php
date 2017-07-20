<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Sleeplab;
use Prettus\Repository\Eloquent\BaseRepository;

class SleeplabRepository extends BaseRepository
{
    public function model()
    {
        return Sleeplab::class;
    }
}
