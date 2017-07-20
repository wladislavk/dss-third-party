<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Joint;
use Prettus\Repository\Eloquent\BaseRepository;

class JointRepository extends BaseRepository
{
    public function model()
    {
        return Joint::class;
    }
}
