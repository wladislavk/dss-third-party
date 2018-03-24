<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\TeethExam;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class TeethExamRepository extends AbstractRepository
{
    public function model()
    {
        return TeethExam::class;
    }
}
