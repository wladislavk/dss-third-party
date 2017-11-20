<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\DeviceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingRepository;
use DentalSleepSolutions\Constants\DeviceSettingTypes;

class DeviceGuideResultsRetriever
{
    const CHECKED_IMP_COEFFICIENT = 1.75;
    const IDS_DELIMETER = '_';
    const SETTINGS_DELIMETER = ',';

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

        $devicesCollection = collect();

        foreach ($devices as $device) {
            $guideSettings = $this->guideSettingRepository->getSettingType($device->deviceid);
            $result = $this->countTotalValue($guideSettings, $settings);

            if (!is_bool($result)) {
                $devicesCollection->push([
                    'name'       => $device->device,
                    'id'         => $device->deviceid,
                    'value'      => $result,
                    'imagePath'  => $device->image_path,
                ]);
            }
        }

        $sortedDevices = $devicesCollection->sortByDesc('value');

        return $sortedDevices->values()->all();
    }

    /**
     * @param  array|\Illuminate\Database\Eloquent\Collection $deviceSettings
     * @param  string $settings
     * @return int|boolean
     */
    private function countTotalValue($deviceSettings, $settings)
    {
        if (count($deviceSettings) === 0) {
            return 0;
        }

        $settings = $this->convertSettings($settings);

        $settingsFields = array_keys($settings);
        $requiredDeviceSettings = $deviceSettings->filter(function ($item) use ($settingsFields) {
            return in_array($item->id, $settingsFields);
        });

        $total = 0;

        foreach ($requiredDeviceSettings as $deviceSetting) {
            $setting = $settings[$deviceSetting->id];

            if (
                $deviceSetting->setting_type === DeviceSettingTypes::DSS_DEVICE_SETTING_TYPE_FLAG
                &&
                $deviceSetting->value != '1'
                &&
                $setting['checked'] == 1
            ) {
                return false;
            }

            if ($deviceSetting->setting_type !== DeviceSettingTypes::DSS_DEVICE_SETTING_TYPE_FLAG) {
                $value = $setting['checked'] * $deviceSetting->value;
                $value = $this->checkIfCheckedImp($setting, $value);

                $total += $value;
            }
        }

        return $total;
    }

    /**
     * @param  array $setting
     * @param  float $value
     * @return float
     */
    private function checkIfCheckedImp($setting, $value)
    {
        if (isset($setting['checked_imp'])) {
            $value *= self::CHECKED_IMP_COEFFICIENT;
        }

        return $value;
    }

    /**
     * @param  string $settings
     * @return array[]
     */
    private function convertSettings($settings)
    {
        if (empty($settings)) {
            return [];
        }

        $settings = explode(self::SETTINGS_DELIMETER, $settings);

        $convertedSettings = [];
        foreach ($settings as $setting) {
            $ids = explode(self::IDS_DELIMETER, $setting);

            if (count($ids) === 2) {
                list($deviceSettingId, $checked) = $ids;
                $convertedSettings[$deviceSettingId] = ['checked' => $checked];
            }

            if (count($ids) === 3) {
                list($deviceSettingId, $checkedImp, $checked) = $ids;
                $convertedSettings[$deviceSettingId] = [
                    'checked_imp' => $checkedImp,
                    'checked' => $checked,
                ];
            }
        }

        return $convertedSettings;
    }
}
