<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\InsuranceDocument;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class InsuranceDocumentRepository extends AbstractRepository
{
    public function model()
    {
        return InsuranceDocument::class;
    }
}
