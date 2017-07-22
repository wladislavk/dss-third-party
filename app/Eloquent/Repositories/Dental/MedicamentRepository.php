<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Medicament;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class MedicamentRepository extends AbstractRepository
{
    public function model()
    {
        return Medicament::class;
    }
}
