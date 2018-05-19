<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\EvaluationManagementExam;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class EvaluationManagementExamRepository extends AbstractRepository
{
    public function model()
    {
        return EvaluationManagementExam::class;
    }
}
