<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\SoftPalate;
use Prettus\Repository\Eloquent\BaseRepository;

class SoftPalateRepository extends BaseRepository
{
    public function model()
    {
        return SoftPalate::class;
    }
}
