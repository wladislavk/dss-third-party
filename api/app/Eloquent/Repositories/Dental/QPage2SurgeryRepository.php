<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\QPage2Surgery;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class QPage2SurgeryRepository extends AbstractRepository
{
    public function model()
    {
        return QPage2Surgery::class;
    }
}
