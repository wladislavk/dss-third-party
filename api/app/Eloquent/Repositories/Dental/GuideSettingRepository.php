<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\GuideSetting;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use DentalSleepSolutions\Structs\GuideSettingsByType;
use Illuminate\Database\Query\JoinClause;
use DB;

class GuideSettingRepository extends AbstractRepository
{
    public function model()
    {
        return GuideSetting::class;
    }

    /**
     * @param string $order
     * @return array
     */
    public function getAllOrderBy($order)
    {
        return $this->model->orderBy($order)->get();
    }

    /**
     * @param int[] $deviceIds
     * @return GuideSettingsByType[]
     */
    public function getSettingsByType(array $deviceIds): array
    {
        $result = $this->model
            ->select('ds.device_id', 'ds.setting_id', 's.setting_type', 'ds.value')
            ->from(DB::raw('dental_device_guide_settings s'))
            ->join(\DB::raw('dental_device_guide_device_setting ds'), 's.id', '=', 'ds.setting_id')
            ->whereIn('ds.device_id', $deviceIds)
            ->get()
            ->toArray()
        ;
        $settings = [];
        foreach ($result as $record) {
            $setting = new GuideSettingsByType();
            $setting->deviceId = $record['device_id'];
            $setting->settingId = $record['setting_id'];
            $setting->settingType = $record['setting_type'];
            $setting->value = $record['value'];
            $settings[] = $setting;
        }
        return $settings;
    }
}
