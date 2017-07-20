<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Mandible;
use Prettus\Repository\Eloquent\BaseRepository;

class MandibleRepository extends BaseRepository
{
    public function model()
    {
        return Mandible::class;
    }
}
