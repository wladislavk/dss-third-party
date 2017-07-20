<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Symptom;
use Prettus\Repository\Eloquent\BaseRepository;

class SymptomRepository extends BaseRepository
{
    public function model()
    {
        return Symptom::class;
    }
}
