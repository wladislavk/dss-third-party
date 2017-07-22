<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\InsuranceFile;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class InsuranceFileRepository extends AbstractRepository
{
    public function model()
    {
        return InsuranceFile::class;
    }
}
