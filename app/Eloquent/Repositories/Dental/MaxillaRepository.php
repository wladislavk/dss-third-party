<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Maxilla;
use Prettus\Repository\Eloquent\BaseRepository;

class MaxillaRepository extends BaseRepository
{
    public function model()
    {
        return Maxilla::class;
    }
}
