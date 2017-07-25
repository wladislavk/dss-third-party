<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Procedure;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ProcedureRepository extends AbstractRepository
{
    public function model()
    {
        return Procedure::class;
    }
}
