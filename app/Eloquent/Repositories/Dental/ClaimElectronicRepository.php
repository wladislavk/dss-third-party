<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ClaimElectronic;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ClaimElectronicRepository extends AbstractRepository
{
    public function model()
    {
        return ClaimElectronic::class;
    }
}
