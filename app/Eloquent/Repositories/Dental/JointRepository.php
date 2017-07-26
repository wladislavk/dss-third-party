<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Joint;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class JointRepository extends AbstractRepository
{
    public function model()
    {
        return Joint::class;
    }
}
