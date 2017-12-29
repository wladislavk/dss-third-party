<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\DeviceSettingsTotalValueGetter;
use DentalSleepSolutions\Helpers\DeviceInfoGetter;
use DentalSleepSolutions\Eloquent\Models\Dental\Device;
use DentalSleepSolutions\Eloquent\Models\Dental\GuideSetting;
use DentalSleepSolutions\Structs\DeviceSettings;
use DentalSleepSolutions\Constants\DeviceSettingTypes;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class DeviceInfoGetterTest extends UnitTestCase
{
    const DEVICE_ID = 1;
    const DEVICE_NAME = 'test name';
    const DEVICE_IMAGE_PATH = 'test image path';
    const DEVICE_TOTAL_VALUE = 86.5;

    /**
     * @var DeviceInfoGetter
     */
    private $deviceInfoGetter;

    /**
     * @var boolean
     */
    private $withTotal;

    public function setUp()
    {
        $this->withTotal = true;

        $deviceSettingsTotalValueGetter = $this->mockDeviceSettingsTotalValueGetter();

        $this->deviceInfoGetter = new DeviceInfoGetter(
            $deviceSettingsTotalValueGetter
        );
    }

    public function testGetWithoutDeviceSettings()
    {
        $device = $this->getDevice();
        $deviceSettings = collect([]);
        $settings = $this->getDeviceSettingsStructData();

        $deviceInfo = $this->deviceInfoGetter->get($device, $deviceSettings, $settings);

        $this->assertEquals(null, $deviceInfo);
    }

    public function testGetWithTotal()
    {
        $device = $this->getDevice();
        $deviceSettings = $this->getGuideSettingData();
        $settings = $this->getDeviceSettingsStructData();

        $deviceInfo = $this->deviceInfoGetter->get($device, $deviceSettings, $settings);

        $expectedDeviceInfo = [
            'id' => self::DEVICE_ID,
            'name' => self::DEVICE_NAME,
            'value' => self::DEVICE_TOTAL_VALUE,
            'imagePath' => self::DEVICE_IMAGE_PATH,
        ];
        $this->assertEquals($expectedDeviceInfo, $deviceInfo);
    }

    public function testGetWithoutTotal()
    {
        $this->withTotal = true;
        $device = $this->getDevice();
        $deviceSettings = $this->getGuideSettingData();
        $settings = $this->getDeviceSettingsStructData();

        $deviceInfo = $this->deviceInfoGetter->get($device, $deviceSettings, $settings);

        $this->assertEquals(null, $deviceInfo);
    }

    private function mockDeviceSettingsTotalValueGetter()
    {
        /** @var DeviceSettingsTotalValueGetter|MockInterface $deviceSettingsTotalValueGetter */
        $deviceSettingsTotalValueGetter = \Mockery::mock(DeviceSettingsTotalValueGetter::class);
        $deviceSettingsTotalValueGetter->shouldReceive('get')
            ->andReturnUsing([$this, 'getTotalValue']);
        return $deviceSettingsTotalValueGetter;
    }

    public function getTotalValue()
    {
        if ($this->withTotal) {
            return self::DEVICE_TOTAL_VALUE;
        }

        return null;
    }

    private function getDevice()
    {
        $device = new Device();
        $device->deviceid = self::DEVICE_ID;
        $device->device = self::DEVICE_NAME;
        $device->image_path = self::DEVICE_IMAGE_PATH;

        return $device;
    }

    private function getDeviceSettingsStructData()
    {
        $deviceSettings1 = new DeviceSettings();
        $deviceSettings1->id = 1;
        $deviceSettings1->checkedRangeValue = 1;

        $deviceSettings2 = new DeviceSettings();
        $deviceSettings2->id = 2;
        $deviceSettings2->checkedRangeValue = 1;

        $deviceSettings3 = new DeviceSettings();
        $deviceSettings3->id = 3;
        $deviceSettings3->impression = 1;
        $deviceSettings3->checkedRangeValue = 1;

        return [$deviceSettings1, $deviceSettings2, $deviceSettings3];
    }

    private function getGuideSettingData()
    {
        $guideSetting = new GuideSetting();
        $guideSetting->id = 1;
        $guideSetting->setting_type = DeviceSettingTypes::DSS_DEVICE_SETTING_TYPE_RANGE;
        $guideSetting->value = 200;

        $guideSettingsCollection = collect([$guideSetting]);

        $guideSetting = new GuideSetting();
        $guideSetting->id = 3;
        $guideSetting->setting_type = DeviceSettingTypes::DSS_DEVICE_SETTING_TYPE_RANGE;
        $guideSetting->value = 200;

        $guideSettingsCollection->push($guideSetting);

        return $guideSettingsCollection;
    }
}
