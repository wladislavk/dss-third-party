<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\SleepTest;
use Prettus\Repository\Eloquent\BaseRepository;

class SleepTestRepository extends BaseRepository
{
    public function model()
    {
        return SleepTest::class;
    }
}
