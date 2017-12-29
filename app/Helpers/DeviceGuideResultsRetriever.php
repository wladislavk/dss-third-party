<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\DeviceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingRepository;
use DentalSleepSolutions\Helpers\DeviceSettingsConverter;
use DentalSleepSolutions\Helpers\DeviceInfoGetter;
use Illuminate\Support\Collection;

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
     * @var DeviceSettingsConverter
     */
    private $deviceSettingsConverter;

    /**
     * @var DeviceInfoGetter
     */
    private $deviceInfoGetter;

    public function __construct(
        DeviceRepository $deviceRepository,
        GuideSettingRepository $guideSettingRepository,
        DeviceSettingsConverter $deviceSettingsConverter,
        DeviceInfoGetter $deviceInfoGetter
    ) {
        $this->deviceRepository = $deviceRepository;
        $this->guideSettingRepository = $guideSettingRepository;
        $this->deviceSettingsConverter = $deviceSettingsConverter;
        $this->deviceInfoGetter = $deviceInfoGetter;
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
}
