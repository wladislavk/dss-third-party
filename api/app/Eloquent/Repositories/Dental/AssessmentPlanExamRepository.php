<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\AssessmentPlanExam;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class AssessmentPlanExamRepository extends AbstractRepository
{
    public function model()
    {
        return AssessmentPlanExam::class;
    }
}
