<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Procedure;
use Prettus\Repository\Eloquent\BaseRepository;

class ProcedureRepository extends BaseRepository
{
    public function model()
    {
        return Procedure::class;
    }
}
