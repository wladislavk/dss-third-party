<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Device;
use DentalSleepSolutions\Eloquent\Repositories\Dental\DeviceRepository;
use DentalSleepSolutions\Eloquent\Models\Dental\GuideSetting;
use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingRepository;
use DentalSleepSolutions\Helpers\DeviceSettingsConverter;
use DentalSleepSolutions\Constants\DeviceSettingTypes;
use DentalSleepSolutions\Structs\DeviceInfo;
use DentalSleepSolutions\Structs\DeviceSettings;

class DeviceGuideResultsRetriever
{
    const IMPRESSION_COEFFICIENT = 1.75;

    /**
     * @var DeviceRepository
     */
    private $deviceRepository;

    /**
     * @var GuideSettingRepository
     */
    private $guideSettingRepository;

    /**
     * @var DeviceSettingsConverter
     */
    private $deviceSettingsConverter;

    public function __construct(
        DeviceRepository $deviceRepository,
        GuideSettingRepository $guideSettingRepository,
        DeviceSettingsConverter $deviceSettingsConverter
    ) {
        $this->deviceRepository = $deviceRepository;
        $this->guideSettingRepository = $guideSettingRepository;
        $this->deviceSettingsConverter = $deviceSettingsConverter;
    }

    /**
     * @param string $settings
     * @return array[]
     */
    public function get($settings)
    {
        $fields = ['deviceid', 'device', 'image_path'];
        $devices = $this->deviceRepository->getWithFilter($fields);

        if (count($devices) === 0) {
            return [];
        }

        $settings = $this->deviceSettingsConverter->convertSettings($settings);
        $devicesCollection = collect();
        foreach ($devices as $device) {
            $guideSettings = $this->guideSettingRepository->getSettingType($device->deviceid);
            $deviceInfo = $this->getDeviceInfo($device, $guideSettings, $settings);

            if ($deviceInfo) {
                $devicesCollection->push($deviceInfo->toArray());
            }
        }

        $sortedDevices = $devicesCollection->sortByDesc('value');

        return $sortedDevices->values()->all();
    }

    /**
     * @param  Device $device
     * @param  array|\Illuminate\Database\Eloquent\Collection $deviceSettings
     * @param  DeviceSettings[]|array $settings
     * @return DeviceInfo|null
     */
    private function getDeviceInfo($device, $deviceSettings, $settings)
    {
        if (count($deviceSettings) === 0) {
            return null;
        }

        $settingsFields = array_keys($settings);
        $requiredDeviceSettings = $deviceSettings->filter(
            function (GuideSetting $item) use ($settingsFields) {
                return in_array($item->id, $settingsFields);
            }
        );

        $total = 0;
        foreach ($requiredDeviceSettings as $deviceSetting) {
            $setting = $settings[$deviceSetting->id];

            if (
                $deviceSetting->setting_type === DeviceSettingTypes::DSS_DEVICE_SETTING_TYPE_FLAG
                &&
                $deviceSetting->value != '1'
                &&
                $setting->checkedRangeValue == 1
            ) {
                return null;
            }

            $coefficient = 1;
            if ($setting->impression) {
                $coefficient = self::IMPRESSION_COEFFICIENT;
            }

            if ($deviceSetting->setting_type !== DeviceSettingTypes::DSS_DEVICE_SETTING_TYPE_FLAG) {
                $value = $setting->checkedRangeValue * $deviceSetting->value * $coefficient;
                $total += $value;
            }
        }

        $deviceInfo = new DeviceInfo();
        $deviceInfo->id = $device->deviceid;
        $deviceInfo->name = $device->device;
        $deviceInfo->value = $total;
        $deviceInfo->imagePath = $device->image_path;

        return $deviceInfo;
    }
}
