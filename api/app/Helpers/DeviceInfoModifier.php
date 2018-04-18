<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Structs\DeviceInfo;
use DentalSleepSolutions\Structs\GuideSettingsByType;

class DeviceInfoModifier
{
    private const IMPRESSION_COEFFICIENT = 1.75;

    /**
     * @param DeviceInfo $deviceInfo
     * @param GuideSettingsByType $deviceSetting
     */
    public function alterDeviceInfo(DeviceInfo $deviceInfo, GuideSettingsByType $deviceSetting): void
    {
        if ($deviceSetting->settingType == 1) {
            $this->hideInfo($deviceInfo, $deviceSetting);
            return;
        }
        $deviceInfo->value += $this->getValueForSetting($deviceSetting);
    }

    /**
     * @param DeviceInfo $deviceInfo
     * @param GuideSettingsByType $deviceSetting
     */
    private function hideInfo(DeviceInfo $deviceInfo, GuideSettingsByType $deviceSetting): void
    {
        if (!$deviceSetting->hasRangeValue) {
            return;
        }
        if ($deviceSetting->value == 1) {
            return;
        }
        $deviceInfo->isHidden = true;
    }

    /**
     * @param GuideSettingsByType $setting
     * @return float
     */
    private function getValueForSetting(GuideSettingsByType $setting): float
    {
        if (!$setting->hasRangeValue) {
            return 0;
        }
        $value = $setting->value;
        if (!$setting->hasImpression) {
            return $value;
        }
        return $value * self::IMPRESSION_COEFFICIENT;
    }
}
