<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Document;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class DocumentRepository extends AbstractRepository
{
    public function model()
    {
        return Document::class;
    }
}
