<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\GuideDevice;
use Prettus\Repository\Eloquent\BaseRepository;

class GuideDeviceRepository extends BaseRepository
{
    public function model()
    {
        return GuideDevice::class;
    }
}
