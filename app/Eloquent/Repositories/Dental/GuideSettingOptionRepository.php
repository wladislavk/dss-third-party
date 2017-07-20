<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\GuideSettingOption;
use Prettus\Repository\Eloquent\BaseRepository;

class GuideSettingOptionRepository extends BaseRepository
{
    public function model()
    {
        return GuideSettingOption::class;
    }
}
