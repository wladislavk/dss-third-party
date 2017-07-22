<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\TmjClinicalExam;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class TmjClinicalExamRepository extends AbstractRepository
{
    public function model()
    {
        return TmjClinicalExam::class;
    }
}
