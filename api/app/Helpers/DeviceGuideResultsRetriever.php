<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Device;
use DentalSleepSolutions\Eloquent\Repositories\Dental\DeviceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingRepository;
use DentalSleepSolutions\Structs\DeviceInfo;
use DentalSleepSolutions\Structs\GuideSettingsByType;

class DeviceGuideResultsRetriever
{
    private const IMPRESSION_COEFFICIENT = 1.75;

    /** @var DeviceRepository */
    private $deviceRepository;

    /** @var GuideSettingRepository */
    private $guideSettingRepository;

    public function __construct(
        DeviceRepository $deviceRepository,
        GuideSettingRepository $guideSettingRepository
    ) {
        $this->deviceRepository = $deviceRepository;
        $this->guideSettingRepository = $guideSettingRepository;
    }

    /**
     * @param int[] $impressions
     * @param int[] $checkedOptions
     * @return array[]
     */
    public function getDeviceGuides(array $impressions, array $checkedOptions): array
    {
        /** @var Device[] $devices */
        $devices = $this->deviceRepository->get();
        $deviceIds = [];
        /** @var DeviceInfo[] $devicesInfo */
        $devicesInfo = [];
        foreach ($devices as $device) {
            $deviceIds[] = $device->deviceid;
            $devicesInfo[] = $this->setDeviceInfo($device, $impressions, $checkedOptions);
        }
        $settings = $this->guideSettingRepository->getSettingsByType($deviceIds);
        foreach ($settings as $deviceSetting) {
            $deviceInfoForSetting = $this->getDeviceInfoForSetting($devicesInfo, $deviceSetting->deviceId);
            if ($deviceInfoForSetting) {
                $this->alterDeviceInfo($deviceInfoForSetting, $deviceSetting);
            }
        }
        $devicesInfo = array_filter($devicesInfo, function (DeviceInfo $element) {
            return !$element->isHidden;
        });
        $devicesInfo = $this->reverseSortByValue($devicesInfo);
        $devicesAsArray = array_map(function (DeviceInfo $element) {
            return $element->toArray();
        }, $devicesInfo);
        return $devicesAsArray;
    }

    /**
     * @param DeviceInfo $deviceInfo
     * @param GuideSettingsByType $deviceSetting
     */
    private function alterDeviceInfo(DeviceInfo $deviceInfo, GuideSettingsByType $deviceSetting): void
    {
        if ($deviceSetting->settingType == 1) {
            $this->hideInfo($deviceInfo, $deviceSetting);
            return;
        }
        $deviceInfo->value += $this->getValueForSetting($deviceInfo, $deviceSetting);
    }

    /**
     * @param Device $device
     * @param int[] $impressions
     * @param int[] $checkedOptions
     * @return DeviceInfo
     */
    private function setDeviceInfo(Device $device, array $impressions, array $checkedOptions): DeviceInfo
    {
        $deviceInfo = new DeviceInfo();
        $deviceInfo->id = $device->deviceid;
        $deviceInfo->name = $device->device;
        $deviceInfo->imagePath = $device->image_path;
        $this->convertParamsToInfo($impressions, $checkedOptions, $device->deviceid, $deviceInfo);
        return $deviceInfo;
    }

    /**
     * @param DeviceInfo[] $devicesInfo
     * @param int $deviceId
     * @return DeviceInfo|null
     */
    private function getDeviceInfoForSetting(array $devicesInfo, int $deviceId): ?DeviceInfo
    {
        foreach ($devicesInfo as $deviceInfo) {
            if ($deviceInfo->id == $deviceId) {
                return $deviceInfo;
            }
        }
        return null;
    }

    /**
     * @param DeviceInfo $deviceInfo
     * @param GuideSettingsByType $setting
     * @return float
     */
    private function getValueForSetting(DeviceInfo $deviceInfo, GuideSettingsByType $setting): float
    {
        if (!$deviceInfo->hasRangeValue) {
            return 0;
        }
        $value = $setting->value;
        if (!$deviceInfo->hasImpression) {
            return $value;
        }
        return $value * self::IMPRESSION_COEFFICIENT;
    }

    /**
     * @param DeviceInfo $deviceInfo
     * @param GuideSettingsByType $deviceSetting
     * @param bool $hasRangeValue
     */
    private function hideInfo(DeviceInfo $deviceInfo, GuideSettingsByType $deviceSetting): void
    {
        if (!$deviceInfo->hasRangeValue) {
            return;
        }
        if ($deviceSetting->value == 1) {
            return;
        }
        $deviceInfo->isHidden = true;
    }

    /**
     * @param bool[] $impressions
     * @param bool[] $checkedOptions
     * @param int $deviceId
     * @param DeviceInfo $deviceInfo
     */
    private function convertParamsToInfo(array $impressions, array $checkedOptions, int $deviceId, DeviceInfo $deviceInfo): void
    {
        if (array_key_exists($deviceId, $impressions)) {
            $deviceInfo->hasImpression = $impressions[$deviceId];
        }
        if (array_key_exists($deviceId, $checkedOptions)) {
            $deviceInfo->hasRangeValue = $checkedOptions[$deviceId];
        }
    }

    /**
     * @param DeviceInfo[] $devices
     * @return DeviceInfo[]
     */
    private function reverseSortByValue(array $devices): array
    {
        usort($devices, function (DeviceInfo $a, DeviceInfo $b) {
            return $b->value <=> $a->value;
        });
        return $devices;
    }
}
