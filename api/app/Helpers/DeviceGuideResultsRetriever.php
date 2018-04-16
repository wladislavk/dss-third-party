<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Device;
use DentalSleepSolutions\Eloquent\Repositories\Dental\DeviceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingRepository;
use DentalSleepSolutions\Structs\DeviceInfo;
use DentalSleepSolutions\Structs\DeviceSettings;

class DeviceGuideResultsRetriever
{
    /**
     * @var DeviceRepository
     */
    private $deviceRepository;

    /**
     * @var GuideSettingRepository
     */
    private $guideSettingRepository;

    /**
     * @var DeviceInfoGetter
     */
    private $deviceInfoGetter;

    public function __construct(
        DeviceRepository $deviceRepository,
        GuideSettingRepository $guideSettingRepository,
        DeviceInfoGetter $deviceInfoGetter
    ) {
        $this->deviceRepository = $deviceRepository;
        $this->guideSettingRepository = $guideSettingRepository;
        $this->deviceInfoGetter = $deviceInfoGetter;
    }

    /**
     * @param string[] $impressions
     * @param string[] $checkedOptions
     * @return array[]
     */
    public function get(array $impressions, array $checkedOptions): array
    {
        /** @var Device[] $devices */
        $devices = $this->deviceRepository->get();
        $convertedSettings = $this->convertSettings($impressions, $checkedOptions);
        $devicesCollection = [];
        foreach ($devices as $device) {
            $guideSettings = $this->guideSettingRepository->getSettingsByType($device->deviceid);
            $deviceInfo = $this->deviceInfoGetter->get($device, $guideSettings, $convertedSettings);
            if ($deviceInfo) {
                $devicesCollection[] = $deviceInfo;
            }
        }
        $devicesCollection = $this->reverseSortByValue($devicesCollection);
        return $devicesCollection;
    }

    /**
     * @param string[] $impressions
     * @param string[] $checkedOptions
     * @return DeviceSettings[]
     */
    private function convertSettings(array $impressions, array $checkedOptions): array
    {
        $converted = [];
        $ids = $this->combineUniqueKeys($impressions, $checkedOptions);
        foreach ($ids as $id) {
            $deviceSettings = new DeviceSettings();
            $deviceSettings->id = $id;
            if (array_key_exists($id, $impressions)) {
                $deviceSettings->impression = (int)$impressions[$id];
            }
            if (array_key_exists($id, $checkedOptions)) {
                $deviceSettings->checkedRangeValue = (int)$checkedOptions[$id];
            }
            $converted[] = $deviceSettings;
        }
        return $converted;
    }

    /**
     * @param string[] $impressions
     * @param string[] $checkedOptions
     * @return int[]
     */
    private function combineUniqueKeys(array $impressions, array $checkedOptions): array
    {
        return array_unique(array_merge(array_keys($impressions), array_keys($checkedOptions)));
    }

    /**
     * @param DeviceInfo[] $devices
     * @return array[]
     */
    private function reverseSortByValue(array $devices): array
    {
        usort($devices, function (DeviceInfo $a, DeviceInfo $b) {
            return $b->value <=> $a->value;
        });
        $devicesAsArray = array_map(function (DeviceInfo $element) {
            return $element->toArray();
        }, $devices);
        return $devicesAsArray;
    }
}
