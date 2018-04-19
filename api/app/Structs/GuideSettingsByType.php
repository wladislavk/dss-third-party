<?php

namespace DentalSleepSolutions\Structs;

class GuideSettingsByType
{
    /** @var int */
    public $deviceId;

    /** @var int */
    public $settingId;

    /** @var int */
    public $settingType;

    /** @var int */
    public $value;

    /** @var bool */
    public $hasImpression = false;

    /** @var bool */
    public $hasRangeValue = true;

}
