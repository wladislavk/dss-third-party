<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Qualifier;
use Prettus\Repository\Eloquent\BaseRepository;

class QualifierRepository extends BaseRepository
{
    public function model()
    {
        return Qualifier::class;
    }
}
