<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\DeviceSettingsTotalValueGetter;
use DentalSleepSolutions\Structs\DeviceSettings;
use Tests\TestCases\UnitTestCase;

class DeviceSettingsTotalValueGetterTest extends UnitTestCase
{
    /** @var DeviceSettings[] */
    private $deviceSettings;

    /** @var DeviceSettingsTotalValueGetter */
    private $deviceSettingsTotalValueGetter;

    public function setUp()
    {
        $firstSetting = new DeviceSettings();
        $firstSetting->id = 1;
        $secondSetting = new DeviceSettings();
        $secondSetting->id = 2;
        $thirdSetting = new DeviceSettings();
        $thirdSetting->id = 3;
        $this->deviceSettings = [$firstSetting, $secondSetting, $thirdSetting];

        $this->deviceSettingsTotalValueGetter = new DeviceSettingsTotalValueGetter();
    }

    public function testGetTotalValue()
    {
        $requiredSettings = [

        ];
    }

    public function testWithWrongSettingType()
    {

    }

    public function testWithWrongValue()
    {

    }

    public function testWithWrongCheckedRangeValue()
    {

    }
}
