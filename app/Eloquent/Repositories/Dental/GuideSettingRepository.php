<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\GuideSetting;
use Prettus\Repository\Eloquent\BaseRepository;

class GuideSettingRepository extends BaseRepository
{
    public function model()
    {
        return GuideSetting::class;
    }
}
