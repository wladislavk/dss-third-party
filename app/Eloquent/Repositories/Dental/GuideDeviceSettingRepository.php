<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\GuideDeviceSetting;
use Prettus\Repository\Eloquent\BaseRepository;

class GuideDeviceSettingRepository extends BaseRepository
{
    public function model()
    {
        return GuideDeviceSetting::class;
    }
}
