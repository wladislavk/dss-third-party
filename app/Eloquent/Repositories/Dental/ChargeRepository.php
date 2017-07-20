<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Charge;
use Prettus\Repository\Eloquent\BaseRepository;

class ChargeRepository extends BaseRepository
{
    public function model()
    {
        return Charge::class;
    }
}
