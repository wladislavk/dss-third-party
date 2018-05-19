<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\AdvancedPainTmdExam;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class AdvancedPainTmdExamRepository extends AbstractRepository
{
    public function model()
    {
        return AdvancedPainTmdExam::class;
    }
}
