<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Chair;
use Prettus\Repository\Eloquent\BaseRepository;

class ChairRepository extends BaseRepository
{
    public function model()
    {
        return Chair::class;
    }
}
