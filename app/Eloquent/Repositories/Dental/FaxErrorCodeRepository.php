<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\FaxErrorCode;
use Prettus\Repository\Eloquent\BaseRepository;

class FaxErrorCodeRepository extends BaseRepository
{
    public function model()
    {
        return FaxErrorCode::class;
    }
}
