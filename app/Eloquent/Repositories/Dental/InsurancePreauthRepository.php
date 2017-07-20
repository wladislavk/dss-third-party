<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\InsurancePreauth;
use Prettus\Repository\Eloquent\BaseRepository;

class InsurancePreauthRepository extends BaseRepository
{
    public function model()
    {
        return InsurancePreauth::class;
    }
}
