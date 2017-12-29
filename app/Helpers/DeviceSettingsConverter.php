<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Structs\DeviceSettings;

class DeviceSettingsConverter
{
    const SETTING_VALUES_DELIMETER = '_';
    const SETTINGS_DELIMETER = ',';
    const SETTING_VALUES_NUMBER_WITHOUT_IMPESSION = 2;
    const SETTING_VALUES_NUMBER_WITH_IMPESSION = 3;

    /**
     * @param  string $settings
     * @return DeviceSettings[]|array
     */
    public function convertSettings($settings)
    {
        if (empty($settings)) {
            return [];
        }

        $settings = explode(self::SETTINGS_DELIMETER, $settings);
        $convertedSettings = [];
        foreach ($settings as $setting) {
            $settingValues = explode(self::SETTING_VALUES_DELIMETER, $setting);
            $deviceSettings = $this->getDeviceSettings($settingValues);

            if ($deviceSettings) {
                $convertedSettings[] = $deviceSettings;
            }
        }

        return $convertedSettings;
    }

    /**
     * @param  int[] $settingValues
     * @return DeviceSettings|null
     */
    private function getDeviceSettings($settingValues)
    {
        $deviceSettings = new DeviceSettings();
        $settingValuesNumber = count($settingValues);

        if ($settingValuesNumber === self::SETTING_VALUES_NUMBER_WITHOUT_IMPESSION) {
            $deviceSettings->id = 0;
            if (!empty($settingValues[0])) {
                $deviceSettings->id = $settingValues[0];
            }

            if (!empty($settingValues[1])) {
                $deviceSettings->checkedRangeValue = $settingValues[1];
            }

            return $deviceSettings;
        }

        if ($settingValuesNumber === self::SETTING_VALUES_NUMBER_WITH_IMPESSION) {
            $deviceSettings->id = 0;
            if (!empty($settingValues[0])) {
                $deviceSettings->id = $settingValues[0];
            }

            if (!empty($settingValues[1])) {
                $deviceSettings->impression = $settingValues[1];
            }

            if (!empty($settingValues[2])) {
                $deviceSettings->checkedRangeValue = $settingValues[2];
            }

            return $deviceSettings;
        }

        return null;
    }
}
