<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\TongueClinicalExam;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class TongueClinicalExamRepository extends AbstractRepository
{
    public function model()
    {
        return TongueClinicalExam::class;
    }
}
