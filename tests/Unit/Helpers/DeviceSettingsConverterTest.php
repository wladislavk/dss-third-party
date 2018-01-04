<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\DeviceSettingsConverter;
use DentalSleepSolutions\Structs\DeviceSettings;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class DeviceSettingsConverterTest extends UnitTestCase
{
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
        $deviceSettings = '1_2,3_2_1,2';
        $result = $this->deviceSettingsConverter->convertSettings($deviceSettings);

        $deviceSettings1 = new DeviceSettings();
        $deviceSettings1->id = 1;
        $deviceSettings1->impression = 0;
        $deviceSettings1->checkedRangeValue = 2;

        $deviceSettings3 = new DeviceSettings();
        $deviceSettings3->id = 3;
        $deviceSettings3->impression = 2;
        $deviceSettings3->checkedRangeValue = 1;

        $expectedResult = [$deviceSettings1, $deviceSettings3];
        $this->assertEquals($expectedResult, $result);
    }
}
