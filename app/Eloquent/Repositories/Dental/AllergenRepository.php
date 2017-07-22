<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Allergen;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class AllergenRepository extends AbstractRepository
{
    public function model()
    {
        return Allergen::class;
    }
}
