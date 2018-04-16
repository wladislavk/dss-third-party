<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Constants\DeviceSettingTypes;
use DentalSleepSolutions\Structs\DeviceSettings;

class DeviceSettingsTotalValueGetter
{
    private const IMPRESSION_COEFFICIENT = 1.75;

    /**
     * @param array[] $requiredDeviceSettings
     * @param DeviceSettings[] $settings
     * @return float|null
     */
    public function get(array $requiredDeviceSettings, array $settings): ?float
    {
        $settingsIds = [];
        foreach ($settings as $setting) {
            $settingsIds[] = $setting->id;
        }
        $total = 0;
        foreach ($requiredDeviceSettings as $deviceSetting) {
            $settingId = array_search($deviceSetting['id'], $settingsIds);
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
     * @param array $deviceSetting
     * @param DeviceSettings $setting
     * @return bool
     */
    private function isSettingTypeUncheckedFlag(array $deviceSetting, DeviceSettings $setting): bool
    {
        if ($deviceSetting['setting_type'] != 1) {
            return false;
        }
        if ($deviceSetting['value'] == 1) {
            return false;
        }
        if ($setting->checkedRangeValue != 1) {
            return false;
        }
        return true;
    }

    /**
     * @param array $deviceSetting
     * @param DeviceSettings $setting
     * @return float
     */
    private function getDeviceInfoTotalValue(array $deviceSetting, DeviceSettings $setting): float
    {
        $coefficient = 1;
        if ($setting->impression) {
            $coefficient = self::IMPRESSION_COEFFICIENT;
        }

        $value = $setting->checkedRangeValue * $deviceSetting['value'] * $coefficient;

        return $value;
    }
}
