<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\MedicalHistory;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class MedicalHistoryRepository extends AbstractRepository
{
    public function model()
    {
        return MedicalHistory::class;
    }
}
