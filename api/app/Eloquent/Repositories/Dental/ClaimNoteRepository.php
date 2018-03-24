<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ClaimNote;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ClaimNoteRepository extends AbstractRepository
{
    public function model()
    {
        return ClaimNote::class;
    }
}
