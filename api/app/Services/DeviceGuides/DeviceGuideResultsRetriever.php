<?php

namespace DentalSleepSolutions\Services\DeviceGuides;

use DentalSleepSolutions\Eloquent\Models\Dental\Device;
use DentalSleepSolutions\Eloquent\Repositories\Dental\DeviceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingRepository;
use DentalSleepSolutions\Structs\DeviceInfo;
use DentalSleepSolutions\Structs\GuideSettingsByType;

class DeviceGuideResultsRetriever
{
    /** @var DeviceRepository */
    private $deviceRepository;

    /** @var GuideSettingRepository */
    private $guideSettingRepository;

    /** @var DeviceInfoModifier */
    private $deviceInfoModifier;

    /** @var DeviceGuideResultsModifier */
    private $deviceGuideResultsModifier;

    public function __construct(
        DeviceRepository $deviceRepository,
        GuideSettingRepository $guideSettingRepository,
        DeviceInfoModifier $deviceInfoModifier,
        DeviceGuideResultsModifier $deviceGuideResultsModifier
    ) {
        $this->deviceRepository = $deviceRepository;
        $this->guideSettingRepository = $guideSettingRepository;
        $this->deviceInfoModifier = $deviceInfoModifier;
        $this->deviceGuideResultsModifier = $deviceGuideResultsModifier;
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
            $devicesInfo[] = $this->setDeviceInfo($device);
        }
        $settings = $this->guideSettingRepository->getSettingsByType($deviceIds);
        foreach ($settings as $deviceSetting) {
            $this->convertParamsToInfo($impressions, $checkedOptions, $deviceSetting);
            $deviceInfoForSetting = $this->getDeviceInfoForSetting($devicesInfo, $deviceSetting->deviceId);
            if ($deviceInfoForSetting) {
                $this->deviceInfoModifier->alterDeviceInfo($deviceInfoForSetting, $deviceSetting);
            }
        }
        return $this->deviceGuideResultsModifier->modifyResult($devicesInfo);
    }

    /**
     * @param Device $device
     * @return DeviceInfo
     */
    private function setDeviceInfo(Device $device): DeviceInfo
    {
        $deviceInfo = new DeviceInfo();
        $deviceInfo->id = $device->deviceid;
        $deviceInfo->name = $device->device;
        $deviceInfo->imagePath = $device->image_path;
        return $deviceInfo;
    }

    /**
     * @param bool[] $impressions
     * @param bool[] $checkedOptions
     * @param GuideSettingsByType $setting
     */
    private function convertParamsToInfo(array $impressions, array $checkedOptions, GuideSettingsByType $setting): void
    {
        if (array_key_exists($setting->settingId, $impressions)) {
            $setting->hasImpression = $impressions[$setting->settingId];
        }
        if (array_key_exists($setting->settingId, $checkedOptions)) {
            $setting->hasRangeValue = $checkedOptions[$setting->settingId];
        }
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
}
