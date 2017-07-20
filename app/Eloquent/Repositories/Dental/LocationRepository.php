<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Location;
use Prettus\Repository\Eloquent\BaseRepository;

class LocationRepository extends BaseRepository
{
    public function model()
    {
        return Location::class;
    }
}
