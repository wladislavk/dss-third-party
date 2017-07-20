<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\GagReflex;
use Prettus\Repository\Eloquent\BaseRepository;

class GagReflexRepository extends BaseRepository
{
    public function model()
    {
        return GagReflex::class;
    }
}
