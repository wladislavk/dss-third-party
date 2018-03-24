<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class MissingToothRepository extends AbstractRepository
{
    public function model()
    {
        return MissingTooth::class;
    }
}
