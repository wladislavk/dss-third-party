<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\GuideSettingOption;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use DB;

class GuideSettingOptionRepository extends AbstractRepository
{
    public function model()
    {
        return GuideSettingOption::class;
    }

    /**
     * @return array
     */
    public function getOptionsBySettingIds()
    {
        return $this->model
            ->select(
                'setting_id as id',
                DB::raw('GROUP_CONCAT(label ORDER BY option_id) as labels'),
                'name',
                'setting_type',
                'options as number'
            )
            ->from(DB::raw('dental_device_guide_setting_options o'))
            ->join(DB::raw('dental_device_guide_settings s'), 's.id', '=', 'o.setting_id')
            ->groupBy('setting_id')
            ->orderBy('rank')
            ->get()
            ->toArray()
        ;
    }
}
