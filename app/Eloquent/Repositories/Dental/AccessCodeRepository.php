<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\AccessCode;
use Prettus\Repository\Eloquent\BaseRepository;

class AccessCodeRepository extends BaseRepository
{
    public function model()
    {
        return AccessCode::class;
    }
}
