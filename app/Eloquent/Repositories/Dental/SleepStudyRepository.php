<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\SleepStudy;
use Prettus\Repository\Eloquent\BaseRepository;

class SleepStudyRepository extends BaseRepository
{
    public function model()
    {
        return SleepStudy::class;
    }
}
