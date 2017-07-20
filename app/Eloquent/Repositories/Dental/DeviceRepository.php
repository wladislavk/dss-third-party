<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Device;
use Prettus\Repository\Eloquent\BaseRepository;

class DeviceRepository extends BaseRepository
{
    public function model()
    {
        return Device::class;
    }
}
