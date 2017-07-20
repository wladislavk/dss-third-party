<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Summary;
use Prettus\Repository\Eloquent\BaseRepository;

class SummaryRepository extends BaseRepository
{
    public function model()
    {
        return Summary::class;
    }
}
