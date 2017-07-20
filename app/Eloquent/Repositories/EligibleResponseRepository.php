<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\EligibleResponse;
use Prettus\Repository\Eloquent\BaseRepository;

class EligibleResponseRepository extends BaseRepository
{
    public function model()
    {
        return EligibleResponse::class;
    }
}
