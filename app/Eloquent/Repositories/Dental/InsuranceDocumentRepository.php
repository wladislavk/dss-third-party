<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\InsuranceDocument;
use Prettus\Repository\Eloquent\BaseRepository;

class InsuranceDocumentRepository extends BaseRepository
{
    public function model()
    {
        return InsuranceDocument::class;
    }
}
