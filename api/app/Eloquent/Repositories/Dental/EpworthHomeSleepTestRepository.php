<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\EpworthHomeSleepTest;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class EpworthHomeSleepTestRepository extends AbstractRepository
{
    public function model()
    {
        return EpworthHomeSleepTest::class;
    }
}
