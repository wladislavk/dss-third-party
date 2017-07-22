<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\SleepStudy;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class SleepStudyRepository extends AbstractRepository
{
    public function model()
    {
        return SleepStudy::class;
    }
}
