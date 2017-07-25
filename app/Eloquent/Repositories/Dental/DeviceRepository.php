<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Device;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class DeviceRepository extends AbstractRepository
{
    public function model()
    {
        return Device::class;
    }
}
