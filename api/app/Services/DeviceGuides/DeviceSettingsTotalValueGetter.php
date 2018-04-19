<?php

namespace DentalSleepSolutions\Services\DeviceGuides;

use DentalSleepSolutions\Constants\DeviceSettingTypes;
use DentalSleepSolutions\Eloquent\Models\Dental\GuideSetting;
use DentalSleepSolutions\Structs\DeviceSettings;

class DeviceSettingsTotalValueGetter
{
    const IMPRESSION_COEFFICIENT = 1.75;

    /**
     * @param  array|\Illuminate\Database\Eloquent\Collection $requiredDeviceSettings
     * @param  DeviceSettings[] $settings
     * @return float|null
     */
    public function get($requiredDeviceSettings, array $settings)
    {
        $settingsFields = [];
        foreach ($settings as $setting) {
            $settingsFields[] = $setting->id;
        }
        $total = 0;
        foreach ($requiredDeviceSettings as $deviceSetting) {
            $settingId = array_search($deviceSetting->id, $settingsFields);
            $setting = $settings[$settingId];
            if ($this->isSettingTypeUncheckedFlag($deviceSetting, $setting)) {
                return null;
            }
            if ($deviceSetting->setting_type !== DeviceSettingTypes::DSS_DEVICE_SETTING_TYPE_FLAG) {
                $total += $this->getDeviceInfoTotalValue($deviceSetting, $setting);
            }
        }
        return $total;
    }

    /**
     * @param GuideSetting $deviceSetting
     * @param DeviceSettings $setting
     * @return bool
     */
    private function isSettingTypeUncheckedFlag(GuideSetting $deviceSetting, DeviceSettings $setting)
    {
        if ($deviceSetting->setting_type !== DeviceSettingTypes::DSS_DEVICE_SETTING_TYPE_FLAG) {
            return false;
        }
        if ($deviceSetting->value === '1') {
            return false;
        }
        if ($setting->checkedRangeValue !== 1) {
            return false;
        }
        return true;
    }

    /**
     * @param GuideSetting $deviceSetting
     * @param DeviceSettings $setting
     * @return float
     */
    private function getDeviceInfoTotalValue(GuideSetting $deviceSetting, DeviceSettings $setting)
    {
        $coefficient = 1;
        if ($setting->impression) {
            $coefficient = self::IMPRESSION_COEFFICIENT;
        }

        $value = $setting->checkedRangeValue * $deviceSetting->value * $coefficient;

        return $value;
    }
}
