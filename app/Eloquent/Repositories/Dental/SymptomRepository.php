<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Symptom;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class SymptomRepository extends AbstractRepository
{
    public function model()
    {
        return Symptom::class;
    }
}
