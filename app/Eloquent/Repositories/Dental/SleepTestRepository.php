<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\SleepTest;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class SleepTestRepository extends AbstractRepository
{
    public function model()
    {
        return SleepTest::class;
    }
}
