<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ModifierCode;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ModifierCodeRepository extends AbstractRepository
{
    public function model()
    {
        return ModifierCode::class;
    }
}
