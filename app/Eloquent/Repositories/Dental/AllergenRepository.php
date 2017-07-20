<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Allergen;
use Prettus\Repository\Eloquent\BaseRepository;

class AllergenRepository extends BaseRepository
{
    public function model()
    {
        return Allergen::class;
    }
}
