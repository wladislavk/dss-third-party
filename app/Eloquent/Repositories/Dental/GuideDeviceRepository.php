<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\GuideDevice;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class GuideDeviceRepository extends AbstractRepository
{
    public function model()
    {
        return GuideDevice::class;
    }
}
