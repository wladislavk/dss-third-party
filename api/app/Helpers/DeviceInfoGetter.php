<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Device;
use DentalSleepSolutions\Structs\DeviceInfo;
use DentalSleepSolutions\Structs\DeviceSettings;

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
     * @param array[] $guideSettings
     * @param DeviceSettings[] $convertedSettings
     * @return DeviceInfo|null
     */
    public function get(Device $device, array $guideSettings, array $convertedSettings): ?DeviceInfo
    {
        if (sizeof($guideSettings) === 0) {
            return null;
        }

        $total = $this->deviceSettingsTotalValueGetter->get($guideSettings, $convertedSettings);

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
