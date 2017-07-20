<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Diagnostic;
use Prettus\Repository\Eloquent\BaseRepository;

class DiagnosticRepository extends BaseRepository
{
    public function model()
    {
        return Diagnostic::class;
    }
}
