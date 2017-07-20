<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\SummSleeplab;
use Prettus\Repository\Eloquent\BaseRepository;

class SummSleeplabRepository extends BaseRepository
{
    public function model()
    {
        return SummSleeplab::class;
    }
}
