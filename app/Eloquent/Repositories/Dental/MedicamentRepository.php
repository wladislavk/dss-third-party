<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Medicament;
use Prettus\Repository\Eloquent\BaseRepository;

class MedicamentRepository extends BaseRepository
{
    public function model()
    {
        return Medicament::class;
    }
}
