<?php

namespace DentalSleepSolutions\Structs;

class DeviceSettings
{
    const DEFAULT_IMPRESSION = 0;
    const DEFAULT_CHECKED_RANGE_VALUE = 1;

    /**
     * @var int
     */
    public $id = 0;

    /**
     * @var int
     */
    public $impression = self::DEFAULT_IMPRESSION;

    /**
     * @var int
     */
    public $checkedRangeValue = self::DEFAULT_CHECKED_RANGE_VALUE;
}
