<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Device;
use DentalSleepSolutions\Eloquent\Models\Dental\GuideSetting;
use DentalSleepSolutions\Structs\DeviceInfo;
use DentalSleepSolutions\Structs\DeviceSettings;
use Illuminate\Database\Eloquent\Collection;

class DeviceInfoGetter
{
    /**
     * @var DeviceSettingsTotalValueGetter
     */
    private $deviceSettingsTotalValueGetter;

    public function __construct(DeviceSettingsTotalValueGetter $deviceSettingsTotalValueGetter)
    {
        $this->deviceSettingsTotalValueGetter = $deviceSettingsTotalValueGetter;
    }

    /**
     * @param Device $device
     * @param Collection $deviceSettings
     * @param DeviceSettings[] $settings
     * @return DeviceInfo|null
     */
    public function get(Device $device, Collection $deviceSettings, array $settings)
    {
        if (sizeof($deviceSettings) === 0) {
            return null;
        }

        $settingsFields = [];
        foreach ($settings as $setting) {
            $settingsFields[] = $setting->id;
        }

        $requiredDeviceSettings = $deviceSettings->filter(
            function (GuideSetting $item) use ($settingsFields) {
                return in_array($item->id, $settingsFields);
            }
        );

        $total = $this->deviceSettingsTotalValueGetter->get($requiredDeviceSettings, $settings);

        if ($total === null) {
            return null;
        }

        $deviceInfo = new DeviceInfo();
        $deviceInfo->id = $device->deviceid;
        $deviceInfo->name = $device->device;
        $deviceInfo->value = $total;
        $deviceInfo->imagePath = $device->image_path;

        return $deviceInfo;
    }
}
