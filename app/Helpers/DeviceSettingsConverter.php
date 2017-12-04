<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Structs\DeviceSettings;

class DeviceSettingsConverter
{
    const SETTING_VALUES_DELIMETER = '_';
    const SETTINGS_DELIMETER = ',';
    const SETTING_VALUES_NUMBER_WITHOUT_IMPESSION = 2;
    const SETTING_VALUES_NUMBER_WITH_IMPESSION = 3;
    const SETTING_VALUES_ARRAY_WITHOUT_IMPESSION = ['device_id', 'value'];
    const SETTING_VALUES_ARRAY_WITH_IMPESSION = ['device_id', 'impression', 'value'];

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
                $convertedSettings[$deviceSettings->id] = $deviceSettings;
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
            $settingValues = array_combine(
                self::SETTING_VALUES_ARRAY_WITHOUT_IMPESSION,
                $settingValues
            );

            $deviceSettings->id = $settingValues['device_id'];
            $deviceSettings->checkedRangeValue = $settingValues['value'];

            return $deviceSettings;
        }

        if ($settingValuesNumber === self::SETTING_VALUES_NUMBER_WITH_IMPESSION) {
            $settingValues = array_combine(
                self::SETTING_VALUES_ARRAY_WITH_IMPESSION,
                $settingValues
            );

            $deviceSettings->id = $settingValues['device_id'];
            $deviceSettings->impression = $settingValues['impression'];
            $deviceSettings->checkedRangeValue = $settingValues['value'];

            return $deviceSettings;
        }

        return null;
    }
}
