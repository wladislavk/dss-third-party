<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Palpation;
use Prettus\Repository\Eloquent\BaseRepository;

class PalpationRepository extends BaseRepository
{
    public function model()
    {
        return Palpation::class;
    }
}
