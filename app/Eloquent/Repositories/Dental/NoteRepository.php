<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Note;
use Prettus\Repository\Eloquent\BaseRepository;

class NoteRepository extends BaseRepository
{
    public function model()
    {
        return Note::class;
    }
}
