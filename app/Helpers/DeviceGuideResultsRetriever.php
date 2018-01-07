<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\DeviceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingRepository;
use DentalSleepSolutions\Structs\DeviceSettings;
use Illuminate\Database\Eloquent\Collection;

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
    public function get(array $impressions, array $checkedOptions)
    {
        $fields = ['deviceid', 'device', 'image_path'];
        $devices = $this->deviceRepository->getWithFilter($fields);
        if (count($devices) === 0) {
            return [];
        }
        $settings = $this->convertSettings($impressions, $checkedOptions);
        $devicesCollection = new Collection();
        foreach ($devices as $device) {
            $guideSettings = $this->guideSettingRepository->getSettingType($device->deviceid);
            $deviceInfo = $this->deviceInfoGetter->get($device, $guideSettings, $settings);
            if ($deviceInfo) {
                $devicesCollection->push($deviceInfo->toArray());
            }
        }
        $sortedDevices = $devicesCollection->sortByDesc('value');
        return $sortedDevices->values()->all();
    }

    /**
     * @param string[] $impressions
     * @param string[] $checkedOptions
     * @return DeviceSettings[]
     */
    private function convertSettings(array $impressions, array $checkedOptions) {
        $converted = [];
        $ids = array_unique(array_merge(array_keys($impressions), array_keys($checkedOptions)));
        foreach ($ids as $id) {
            $deviceSettings = new DeviceSettings();
            $deviceSettings->id = (int)$id;
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
}
