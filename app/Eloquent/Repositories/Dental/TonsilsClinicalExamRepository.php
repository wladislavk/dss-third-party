<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\TonsilsClinicalExam;
use Prettus\Repository\Eloquent\BaseRepository;

class TonsilsClinicalExamRepository extends BaseRepository
{
    public function model()
    {
        return TonsilsClinicalExam::class;
    }
}
