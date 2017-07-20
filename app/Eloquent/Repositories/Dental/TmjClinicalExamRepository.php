<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\TmjClinicalExam;
use Prettus\Repository\Eloquent\BaseRepository;

class TmjClinicalExamRepository extends BaseRepository
{
    public function model()
    {
        return TmjClinicalExam::class;
    }
}
