<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\GuideDeviceSetting;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class GuideDeviceSettingRepository extends AbstractRepository
{
    public function model()
    {
        return GuideDeviceSetting::class;
    }
}
