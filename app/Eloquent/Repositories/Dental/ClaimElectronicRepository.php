<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ClaimElectronic;
use Prettus\Repository\Eloquent\BaseRepository;

class ClaimElectronicRepository extends BaseRepository
{
    public function model()
    {
        return ClaimElectronic::class;
    }
}
