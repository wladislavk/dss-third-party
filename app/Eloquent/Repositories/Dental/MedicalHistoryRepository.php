<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\MedicalHistory;
use Prettus\Repository\Eloquent\BaseRepository;

class MedicalHistoryRepository extends BaseRepository
{
    public function model()
    {
        return MedicalHistory::class;
    }
}
