<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\DeviceSettingsConverter;
use DentalSleepSolutions\Structs\DeviceSettings;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class DeviceSettingsConverterTest extends UnitTestCase
{
    const DEVICE_SETTINGS = '1_1,3_1_1';

    /**
     * @var DeviceSettingsConverter
     */
    private $deviceSettingsConverter;

    public function setUp()
    {
        $this->deviceSettingsConverter = new DeviceSettingsConverter();
    }

    public function testConvertSettingsIfEmpty()
    {
        $result = $this->deviceSettingsConverter->convertSettings('');

        $this->assertEquals([], $result);
    }

    public function testConvertSettings()
    {
        $result = $this->deviceSettingsConverter->convertSettings(self::DEVICE_SETTINGS);

        $expectedResult = $this->getFakeConvertedSettings();
        $this->assertEquals($expectedResult, $result);
    }

    public function testConvertSettingsWithWrongData()
    {
        $result = $this->deviceSettingsConverter->convertSettings('1,2');

        $this->assertEquals([], $result);
    }

    private function getFakeConvertedSettings()
    {
        $deviceSettings1 = new DeviceSettings();
        $deviceSettings1->id = 1;
        $deviceSettings1->checkedRangeValue = 1;

        $deviceSettings3 = new DeviceSettings();
        $deviceSettings3->id = 3;
        $deviceSettings3->impression = 1;
        $deviceSettings3->checkedRangeValue = 1;

        return [
            $deviceSettings1->id => $deviceSettings1,
            $deviceSettings3->id => $deviceSettings3,
        ];
    }
}
