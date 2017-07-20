<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\JointExam;
use Prettus\Repository\Eloquent\BaseRepository;

class JointExamRepository extends BaseRepository
{
    public function model()
    {
        return JointExam::class;
    }
}
