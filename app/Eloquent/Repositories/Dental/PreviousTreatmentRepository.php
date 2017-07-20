<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\PreviousTreatment;
use Prettus\Repository\Eloquent\BaseRepository;

class PreviousTreatmentRepository extends BaseRepository
{
    public function model()
    {
        return PreviousTreatment::class;
    }
}
