<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\NasalPassage;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class NasalPassageRepository extends AbstractRepository
{
    public function model()
    {
        return NasalPassage::class;
    }
}
