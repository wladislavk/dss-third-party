<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Structs\DeviceSettings;

class DeviceSettingsConverter
{
    const SETTING_VALUES_DELIMITER = '_';
    const SETTINGS_DELIMITER = ',';

    /**
     * @param string $settings
     * @return DeviceSettings[]
     */
    public function convertSettings($settings)
    {
        if (!$settings) {
            return [];
        }
        $settings = explode(self::SETTINGS_DELIMITER, $settings);
        $convertedSettings = [];
        foreach ($settings as $setting) {
            $settingValues = explode(self::SETTING_VALUES_DELIMITER, $setting);
            if (isset($settingValues[1])) {
                $convertedSettings[] = $this->getDeviceSettings($settingValues);
            }
        }
        return $convertedSettings;
    }

    /**
     * @param string[] $settingValues
     * @return DeviceSettings|null
     */
    private function getDeviceSettings(array $settingValues)
    {
        $deviceSettings = new DeviceSettings();
        $deviceSettings->id = (int)$settingValues[0];
        $deviceSettings->checkedRangeValue = (int)$settingValues[1];
        if (isset($settingValues[2])) {
            $deviceSettings->impression = (int)$settingValues[1];
            $deviceSettings->checkedRangeValue = (int)$settingValues[2];
        }
        return $deviceSettings;
    }
}
