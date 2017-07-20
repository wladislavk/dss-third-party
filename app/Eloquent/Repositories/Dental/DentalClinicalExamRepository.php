<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\DentalClinicalExam;
use Prettus\Repository\Eloquent\BaseRepository;

class DentalClinicalExamRepository extends BaseRepository
{
    public function model()
    {
        return DentalClinicalExam::class;
    }
}
