<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\HomeSleepTest;
use Prettus\Repository\Eloquent\BaseRepository;

class HomeSleepTestRepository extends BaseRepository
{
    public function model()
    {
        return HomeSleepTest::class;
    }
}
