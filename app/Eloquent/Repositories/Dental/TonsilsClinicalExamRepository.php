<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\TonsilsClinicalExam;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class TonsilsClinicalExamRepository extends AbstractRepository
{
    public function model()
    {
        return TonsilsClinicalExam::class;
    }
}
