<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\DeviceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingRepository;

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

    public function __construct(
        DeviceRepository $deviceRepository,
        GuideSettingRepository $guideSettingRepository
    ) {
        $this->deviceRepository = $deviceRepository;
        $this->guideSettingRepository = $guideSettingRepository;
    }

    /**
     * @param  array  $settings
     * @return [type]
     */
    public function get(array $settings)
    {
        $fields = ['deviceid', 'device', 'image_path'];
        $devices = $this->deviceRepository->getWithFilter($fields);
        $devicesArray = [];

        if (count($devices) === 0) {
            return [];
        }

        foreach ($devices as $device) {
            $total = 0;
            $show = true;

            $guideSettings = $guideSettingRepository->getSettingType($device->deviceid);

            if (count($guideSettings)) {
                foreach ($guideSettings as $guideSetting) {
                    if (empty($settings[$guideSetting->id])) {
                        continue;
                    }

                    $setting = $settings[$guideSetting->id];

                    if ($guideSetting->setting_type == 1) {
                        if ($guideSetting->value != '1' && $setting['checked'] == 1) {
                            $show = false;
                        }
                    } else {
                        $value = $setting['checked'] * $guideSetting->value;

                        if (isset($setting['checkedImp'])) {
                            $value *= 1.75;
                        }

                        $total += $value;
                    }
                }
            }

            if (!$show) {
                continue;
            }

            array_push($devicesArray, [
                'name'       => $device->device,
                'id'         => $device->deviceid,
                'value'      => $total,
                'imagePath'  => $device->image_path,
            ]);
        }

        usort($devicesArray, [$this, 'sortDevices']);
    }

    private function sortDevices($firstElement, $secondElement)
    {
        if ($firstElement['value'] == $secondElement['value']) {
            return 0;
        }
        return ($firstElement['value'] > $secondElement['value']) ? -1 : 1;
    }
}
