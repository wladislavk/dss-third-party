<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\DeviceGuideResultsRetriever;
use DentalSleepSolutions\Eloquent\Repositories\Dental\DeviceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingRepository;
use DentalSleepSolutions\Eloquent\Models\Dental\Device;
use DentalSleepSolutions\Eloquent\Models\Dental\GuideSetting;
use DentalSleepSolutions\Constants\DeviceSettingTypes;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class DeviceGuideResultsRetrieverTest extends UnitTestCase
{
    const DEVICE_NAME = 'test name';
    const DEVICE_IMAGE_PATH = 'test image path';
    const DEVICE_VALUE = 200;

    /**
     * @var DeviceGuideResultsRetriever
     */
    private $deviceGuideResultsRetriever;

    public function setUp()
    {
        $deviceRepository = $this->mockDeviceRepository();
        $guideSettingRepository = $this->mockGuideSettingRepository();
        $this->deviceGuideResultsRetriever = new DeviceGuideResultsRetriever(
            $deviceRepository,
            $guideSettingRepository
        );
    }

    public function testGet()
    {
        $settings = '1_1,2_1,3_1_1';
        $devicesArray = $this->deviceGuideResultsRetriever->get($settings);

        $expectedTotalValue = DeviceGuideResultsRetriever::CHECKED_IMP_COEFFICIENT
            *
            self::DEVICE_VALUE
            +
            self::DEVICE_VALUE
        ;

        $this->assertEquals(self::DEVICE_NAME, $devicesArray[0]['name']);
        $this->assertEquals(self::DEVICE_IMAGE_PATH, $devicesArray[0]['imagePath']);
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
}
