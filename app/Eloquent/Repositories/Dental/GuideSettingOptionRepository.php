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

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOptionsBySettingIds()
    {
        return $this->model->select(
            \DB::raw('setting_id as id'),
            \DB::raw('GROUP_CONCAT(label ORDER BY option_id) as labels'),
            'name',
            'setting_type',
            \DB::raw('options as number')
        )->from(\DB::raw('dental_device_guide_setting_options o'))
            ->join(\DB::raw('dental_device_guide_settings s'), 's.id', '=', 'o.setting_id')
            ->groupBy('setting_id')
            ->orderBy('rank')
            ->get();
    }
}
