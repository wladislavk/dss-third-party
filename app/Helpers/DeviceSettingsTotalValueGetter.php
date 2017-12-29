<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Constants\DeviceSettingTypes;

class DeviceSettingsTotalValueGetter
{
    const IMPRESSION_COEFFICIENT = 1.75;

    /**
     * @param  array|\Illuminate\Database\Eloquent\Collection $requiredDeviceSettings
     * @param  DeviceSettings[]|array $settingsFields
     * @return float|null
     */
    public function get($requiredDeviceSettings, $settings)
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
     * @param  GuideSetting $deviceSetting
     * @param  DeviceSettings $setting
     * @return boolean
     */
    private function isSettingTypeUncheckedFlag($deviceSetting, $setting)
    {
        return $deviceSetting->setting_type === DeviceSettingTypes::DSS_DEVICE_SETTING_TYPE_FLAG
            &&
            $deviceSetting->value !== '1'
            &&
            $setting->checkedRangeValue === 1
        ;
    }

    /**
     * @param  GuideSetting $deviceSetting
     * @param  DeviceSettings $setting
     * @return float
     */
    private function getDeviceInfoTotalValue($deviceSetting, $setting)
    {
        $coefficient = 1;
        if ($setting->impression) {
            $coefficient = self::IMPRESSION_COEFFICIENT;
        }

        $value = $setting->checkedRangeValue * $deviceSetting->value * $coefficient;

        return $value;
    }
}
