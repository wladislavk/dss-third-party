<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\PainTmdExam;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class PainTmdExamRepository extends AbstractRepository
{
    public function model()
    {
        return PainTmdExam::class;
    }
}
