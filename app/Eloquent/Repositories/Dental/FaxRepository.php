<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Fax;
use Prettus\Repository\Eloquent\BaseRepository;

class FaxRepository extends BaseRepository
{
    public function model()
    {
        return Fax::class;
    }
}
