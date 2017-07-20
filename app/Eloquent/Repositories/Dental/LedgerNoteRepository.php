<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\LedgerNote;
use Prettus\Repository\Eloquent\BaseRepository;

class LedgerNoteRepository extends BaseRepository
{
    public function model()
    {
        return LedgerNote::class;
    }
}
