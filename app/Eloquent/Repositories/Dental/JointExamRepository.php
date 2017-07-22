<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\JointExam;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class JointExamRepository extends AbstractRepository
{
    public function model()
    {
        return JointExam::class;
    }
}
