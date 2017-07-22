<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\DentalClinicalExam;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class DentalClinicalExamRepository extends AbstractRepository
{
    public function model()
    {
        return DentalClinicalExam::class;
    }
}
