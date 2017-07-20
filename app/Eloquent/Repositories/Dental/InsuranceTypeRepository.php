<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\InsuranceType;
use Prettus\Repository\Eloquent\BaseRepository;

class InsuranceTypeRepository extends BaseRepository
{
    public function model()
    {
        return InsuranceType::class;
    }
}
