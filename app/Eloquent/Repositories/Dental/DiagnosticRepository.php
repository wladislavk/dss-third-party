<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Diagnostic;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class DiagnosticRepository extends AbstractRepository
{
    public function model()
    {
        return Diagnostic::class;
    }
}
