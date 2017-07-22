<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\PlaceService;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class PlaceServiceRepository extends AbstractRepository
{
    public function model()
    {
        return PlaceService::class;
    }
}
