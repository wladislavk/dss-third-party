<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Structs\DeviceInfo;

class DeviceGuideResultsModifier
{
    /**
     * @param DeviceInfo[] $devicesInfo
     * @return array[]
     */
    public function modifyResult(array $devicesInfo): array
    {
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
