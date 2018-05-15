<?php

namespace Tests\Unit\Services\DeviceGuides;

use DentalSleepSolutions\Services\DeviceGuides\DeviceInfoModifier;
use DentalSleepSolutions\Structs\DeviceInfo;
use DentalSleepSolutions\Structs\GuideSettingsByType;
use Tests\TestCases\UnitTestCase;

class DeviceInfoModifierTest extends UnitTestCase
{
    /** @var DeviceInfo */
    private $deviceInfo;

    /** @var DeviceInfoModifier */
    private $deviceInfoModifier;

    public function setUp()
    {
        $this->deviceInfo = new DeviceInfo();
        $this->deviceInfo->isHidden = false;
        $this->deviceInfo->value = 10.0;

        $this->deviceInfoModifier = new DeviceInfoModifier();
    }

    public function testWithSettingTypeOne()
    {
        $deviceSetting = new GuideSettingsByType();
        $deviceSetting->settingType = 1;
        $deviceSetting->hasImpression = false;
        $deviceSetting->hasRangeValue = true;
        $deviceSetting->value = 2;
        $this->deviceInfoModifier->alterDeviceInfo($this->deviceInfo, $deviceSetting);
        $this->assertEquals(true, $this->deviceInfo->isHidden);
        $this->assertEquals(10.0, $this->deviceInfo->value);
    }

    public function testWithSettingTypeOneWithoutRangeValue()
    {
        $deviceSetting = new GuideSettingsByType();
        $deviceSetting->settingType = 1;
        $deviceSetting->hasImpression = false;
        $deviceSetting->hasRangeValue = false;
        $deviceSetting->value = 2;
        $this->deviceInfoModifier->alterDeviceInfo($this->deviceInfo, $deviceSetting);
        $this->assertEquals(false, $this->deviceInfo->isHidden);
        $this->assertEquals(10.0, $this->deviceInfo->value);
    }

    public function testWithSettingTypeOneWithoutImpression()
    {
        $deviceSetting = new GuideSettingsByType();
        $deviceSetting->settingType = 1;
        $deviceSetting->hasImpression = false;
        $deviceSetting->hasRangeValue = true;
        $deviceSetting->value = 1;
        $this->deviceInfoModifier->alterDeviceInfo($this->deviceInfo, $deviceSetting);
        $this->assertEquals(false, $this->deviceInfo->isHidden);
        $this->assertEquals(10.0, $this->deviceInfo->value);
    }

    public function testWithSettingTypeTwo()
    {
        $deviceSetting = new GuideSettingsByType();
        $deviceSetting->settingType = 2;
        $deviceSetting->hasImpression = true;
        $deviceSetting->hasRangeValue = true;
        $deviceSetting->value = 2;
        $this->deviceInfoModifier->alterDeviceInfo($this->deviceInfo, $deviceSetting);
        $this->assertEquals(false, $this->deviceInfo->isHidden);
        $this->assertEquals(13.5, $this->deviceInfo->value);
    }

    public function testWithSettingTypeTwoWithoutRangeValue()
    {
        $deviceSetting = new GuideSettingsByType();
        $deviceSetting->settingType = 2;
        $deviceSetting->hasImpression = true;
        $deviceSetting->hasRangeValue = false;
        $deviceSetting->value = 2;
        $this->deviceInfoModifier->alterDeviceInfo($this->deviceInfo, $deviceSetting);
        $this->assertEquals(false, $this->deviceInfo->isHidden);
        $this->assertEquals(10.0, $this->deviceInfo->value);
    }

    public function testWithSettingTypeTwoWithoutImpression()
    {
        $deviceSetting = new GuideSettingsByType();
        $deviceSetting->settingType = 2;
        $deviceSetting->hasImpression = false;
        $deviceSetting->hasRangeValue = true;
        $deviceSetting->value = 2;
        $this->deviceInfoModifier->alterDeviceInfo($this->deviceInfo, $deviceSetting);
        $this->assertEquals(false, $this->deviceInfo->isHidden);
        $this->assertEquals(12.0, $this->deviceInfo->value);
    }
}
