<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\DeviceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingRepository;
use DentalSleepSolutions\Constants\DeviceSettingTypes;

class DeviceGuideResultsRetriever
{
    const CHECKED_IMP_COEFFICIENT = 1.75;

    /**
     * @var DeviceRepository
     */
    private $deviceRepository;

    /**
     * @var GuideSettingRepository
     */
    private $guideSettingRepository;

    public function __construct(
        DeviceRepository $deviceRepository,
        GuideSettingRepository $guideSettingRepository
    ) {
        $this->deviceRepository = $deviceRepository;
        $this->guideSettingRepository = $guideSettingRepository;
    }

    /**
     * @param  array $settings
     * @return array[]
     */
    public function get(array $settings)
    {
        $fields = ['deviceid', 'device', 'image_path'];
        $devices = $this->deviceRepository->getWithFilter($fields);

        if (count($devices) === 0) {
            return [];
        }

        $devicesCollection = collect();

        foreach ($devices as $device) {
            $guideSettings = $this->guideSettingRepository->getSettingType($device->deviceid);
            $result = $this->countTotalValue($guideSettings, $settings);

            if (is_bool($result) && !$result) {
                continue;
            }

            $devicesCollection->push([
                'name'       => $device->device,
                'id'         => $device->deviceid,
                'value'      => $result,
                'imagePath'  => $device->image_path,
            ]);
        }

        $sortedDevices = $devicesCollection->sortByDesc('value');

        return $sortedDevices->values()->all();
    }

    /**
     * @param  array|\Illuminate\Database\Eloquent\Collection $deviceSettings
     * @param  array $settings
     * @return int|boolean
     */
    private function countTotalValue($deviceSettings, array $settings)
    {
        if (count($deviceSettings) === 0) {
            return 0;
        }

        $settingsFields = array_keys($settings);
        $requiredDeviceSettings = $deviceSettings->filter(function ($item) use ($settingsFields) {
            return in_array($item->id, $settingsFields);
        });

        $total = 0;

        foreach ($requiredDeviceSettings as $deviceSetting) {
            $setting = $settings[$deviceSetting->id];

            if (
                $deviceSetting->setting_type == DeviceSettingTypes::DSS_DEVICE_SETTING_TYPE_FLAG
                &&
                $deviceSetting->value != '1'
                &&
                $setting['checked'] == 1
            ) {
                return false;
            }

            if ($deviceSetting->setting_type == DeviceSettingTypes::DSS_DEVICE_SETTING_TYPE_FLAG) {
                continue;
            }

            $value = $setting['checked'] * $deviceSetting->value;
            if (isset($setting['checkedImp'])) {
                $value *= self::CHECKED_IMP_COEFFICIENT;
            }

            $total += $value;
        }

        return $total;
    }
}
