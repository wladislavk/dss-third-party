<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\DeviceGuideResultsRetriever;
use DentalSleepSolutions\Helpers\DeviceSettingsConverter;
use DentalSleepSolutions\Eloquent\Repositories\Dental\DeviceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingRepository;
use DentalSleepSolutions\Eloquent\Models\Dental\Device;
use DentalSleepSolutions\Eloquent\Models\Dental\GuideSetting;
use DentalSleepSolutions\Constants\DeviceSettingTypes;
use DentalSleepSolutions\Structs\DeviceSettings;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class DeviceGuideResultsRetrieverTest extends UnitTestCase
{
    const DEVICE_NAME = 'test name';
    const DEVICE_IMAGE_PATH = 'test image path';
    const DEVICE_VALUE = 200;
    const DEVICE_SETTINGS = '1_1,2_1,3_1_1';

    /**
     * @var DeviceGuideResultsRetriever
     */
    private $deviceGuideResultsRetriever;

    public function setUp()
    {
        $deviceRepository = $this->mockDeviceRepository();
        $guideSettingRepository = $this->mockGuideSettingRepository();
        $deviceSettingsConverter = $this->mockDeviceSettingsConverter();

        $this->deviceGuideResultsRetriever = new DeviceGuideResultsRetriever(
            $deviceRepository,
            $guideSettingRepository,
            $deviceSettingsConverter
        );
    }

    public function testGet()
    {
        $devicesArray = $this->deviceGuideResultsRetriever->get(self::DEVICE_SETTINGS);

        $expectedTotalValue = DeviceGuideResultsRetriever::IMPRESSION_COEFFICIENT
            *
            self::DEVICE_VALUE
            +
            self::DEVICE_VALUE
        ;

        $this->assertEquals(self::DEVICE_NAME, $devicesArray[0]['name']);
        $this->assertEquals(self::DEVICE_IMAGE_PATH, $devicesArray[0]['image_path']);
        $this->assertEquals($expectedTotalValue, $devicesArray[0]['value']);
    }

    private function mockDeviceRepository()
    {
        /** @var DeviceRepository|MockInterface $deviceRepository */
        $deviceRepository = \Mockery::mock(DeviceRepository::class);
        $deviceRepository->shouldReceive('getWithFilter')
            ->andReturnUsing(function () {
                $device = new Device();

                $device->deviceid = 1;
                $device->device = self::DEVICE_NAME;
                $device->image_path = self::DEVICE_IMAGE_PATH;

                return [$device];
            });
        return $deviceRepository;
    }

    private function mockGuideSettingRepository()
    {
        /** @var GuideSettingRepository|MockInterface $guideSettingRepository */
        $guideSettingRepository = \Mockery::mock(GuideSettingRepository::class);
        $guideSettingRepository->shouldReceive('getSettingType')
            ->andReturnUsing(function () {
                $guideSetting = new GuideSetting();
                $guideSetting->id = 1;
                $guideSetting->setting_type = DeviceSettingTypes::DSS_DEVICE_SETTING_TYPE_RANGE;
                $guideSetting->value = self::DEVICE_VALUE;

                $guideSettingsCollection = collect([$guideSetting]);

                $guideSetting = new GuideSetting();
                $guideSetting->id = 3;
                $guideSetting->setting_type = DeviceSettingTypes::DSS_DEVICE_SETTING_TYPE_RANGE;
                $guideSetting->value = self::DEVICE_VALUE;

                $guideSettingsCollection->push($guideSetting);

                return $guideSettingsCollection;
            });
        return $guideSettingRepository;
    }

    public function mockDeviceSettingsConverter()
    {
        /** @var DeviceSettingsConverter|MockInterface $deviceSettingsConverter */
        $deviceSettingsConverter = \Mockery::mock(DeviceSettingsConverter::class);
        $deviceSettingsConverter->shouldReceive('convertSettings')
            ->with(self::DEVICE_SETTINGS)
            ->andReturnUsing(function () {
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

                return [
                    $deviceSettings1->id => $deviceSettings1,
                    $deviceSettings2->id => $deviceSettings2,
                    $deviceSettings3->id => $deviceSettings3,
                ];
            });

        return $deviceSettingsConverter;
    }
}
