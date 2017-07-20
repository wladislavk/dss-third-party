<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use Prettus\Repository\Eloquent\BaseRepository;

class LetterRepository extends BaseRepository
{
    public function model()
    {
        return Letter::class;
    }
}
