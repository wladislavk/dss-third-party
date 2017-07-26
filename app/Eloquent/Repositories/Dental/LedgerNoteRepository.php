<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\LedgerNote;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class LedgerNoteRepository extends AbstractRepository
{
    public function model()
    {
        return LedgerNote::class;
    }
}
