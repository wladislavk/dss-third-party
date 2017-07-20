<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\PlaceService;
use Prettus\Repository\Eloquent\BaseRepository;

class PlaceServiceRepository extends BaseRepository
{
    public function model()
    {
        return PlaceService::class;
    }
}
