<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\TongueClinicalExam;
use Prettus\Repository\Eloquent\BaseRepository;

class TongueClinicalExamRepository extends BaseRepository
{
    public function model()
    {
        return TongueClinicalExam::class;
    }
}
