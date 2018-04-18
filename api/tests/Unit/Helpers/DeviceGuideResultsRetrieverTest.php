<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\DeviceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingRepository;
use DentalSleepSolutions\Helpers\DeviceGuideResultsModifier;
use DentalSleepSolutions\Helpers\DeviceGuideResultsRetriever;
use DentalSleepSolutions\Eloquent\Models\Dental\Device;
use DentalSleepSolutions\Helpers\DeviceInfoModifier;
use DentalSleepSolutions\Structs\DeviceInfo;
use DentalSleepSolutions\Structs\GuideSettingsByType;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class DeviceGuideResultsRetrieverTest extends UnitTestCase
{
    /** @var Device[] */
    private $devices = [];

    /** @var GuideSettingsByType[] */
    private $settings = [];

    /** @var DeviceGuideResultsRetriever */
    private $deviceGuideResultsRetriever;

    public function setUp()
    {
        $firstDevice = new Device();
        $firstDevice->deviceid = 1;
        $firstDevice->device = 'test name';
        $firstDevice->image_path = 'test image path';
        $secondDevice = new Device();
        $secondDevice->deviceid = 2;
        $secondDevice->device = 'test name2';
        $secondDevice->image_path = 'test image path2';
        $this->devices = [$firstDevice, $secondDevice];

        $firstSetting = new GuideSettingsByType();
        $firstSetting->settingId = 1;
        $firstSetting->deviceId = 1;
        $firstSetting->value = 10;
        $secondSetting = new GuideSettingsByType();
        $secondSetting->settingId = 2;
        $secondSetting->deviceId = 1;
        $secondSetting->value = 20;
        $thirdSetting = new GuideSettingsByType();
        $thirdSetting->settingId = 3;
        $thirdSetting->deviceId = 2;
        $thirdSetting->value = 30;
        $fourthSetting = new GuideSettingsByType();
        $fourthSetting->settingId = 4;
        $fourthSetting->deviceId = 2;
        $fourthSetting->value = 40;
        $fifthSetting = new GuideSettingsByType();
        $fifthSetting->settingId = 5;
        $fifthSetting->deviceId = 3;
        $fifthSetting->value = 50;
        $this->settings = [$firstSetting, $secondSetting, $thirdSetting, $fourthSetting, $fifthSetting];

        $deviceRepository = $this->mockDeviceRepository();
        $guideSettingRepository = $this->mockGuideSettingRepository();
        $deviceInfoModifier = $this->mockDeviceInfoModifier();
        $deviceGuideResultsModifier = $this->mockDeviceGuideResultsModifier();
        $this->deviceGuideResultsRetriever = new DeviceGuideResultsRetriever(
            $deviceRepository, $guideSettingRepository, $deviceInfoModifier, $deviceGuideResultsModifier
        );
    }

    public function testGetDeviceGuides()
    {
        $impressions = [1 => false, 3 => true];
        $checkedOptions = [2 => true, 4 => false];
        $devicesArray = $this->deviceGuideResultsRetriever->getDeviceGuides($impressions, $checkedOptions);
        $expected = [
            [
                'id' => 1,
                'name' => 'test name',
                'value' => 100,
                'image_path' => 'test image path',
            ],
            [
                'id' => 2,
                'name' => 'test name2',
                'value' => 40,
                'image_path' => 'test image path2',
            ],
        ];
        $this->assertEquals($expected, $devicesArray);
    }

    private function mockDeviceRepository()
    {
        /** @var DeviceRepository|MockInterface $deviceRepository */
        $deviceRepository = \Mockery::mock(DeviceRepository::class);
        $deviceRepository->shouldReceive('get')->andReturnUsing(function () {
            return $this->devices;
        });
        return $deviceRepository;
    }

    private function mockGuideSettingRepository()
    {
        /** @var GuideSettingRepository|MockInterface $guideSettingRepository */
        $guideSettingRepository = \Mockery::mock(GuideSettingRepository::class);
        $guideSettingRepository->shouldReceive('getSettingsByType')->andReturnUsing(function (array $deviceIds) {
            $settings = [];
            foreach ($this->settings as $setting) {
                if (in_array($setting->deviceId, $deviceIds)) {
                    $settings[] = $setting;
                }
            }
            return $settings;
        });
        return $guideSettingRepository;
    }

    private function mockDeviceInfoModifier()
    {
        /** @var DeviceInfoModifier|MockInterface $deviceInfoModifier */
        $deviceInfoModifier = \Mockery::mock(DeviceInfoModifier::class);
        $deviceInfoModifier->shouldReceive('alterDeviceInfo')->andReturnUsing(function (DeviceInfo $deviceInfo, GuideSettingsByType $setting) {
            if ($setting->hasImpression) {
                $deviceInfo->value = 0;
                return;
            }
            if ($setting->hasRangeValue) {
                $deviceInfo->value = 100;
                return;
            }
            $deviceInfo->value += $setting->value;
        });
        return $deviceInfoModifier;
    }

    private function mockDeviceGuideResultsModifier()
    {
        /** @var DeviceGuideResultsModifier|MockInterface $deviceGuideResultsModifier */
        $deviceGuideResultsModifier = \Mockery::mock(DeviceGuideResultsModifier::class);
        $deviceGuideResultsModifier->shouldReceive('modifyResult')->andReturnUsing(function (array $devicesInfo) {
            $result = [];
            /** @var DeviceInfo $deviceInfo */
            foreach ($devicesInfo as $deviceInfo) {
                $result[] = $deviceInfo->toArray();
            }
            return $result;
        });
        return $deviceGuideResultsModifier;
    }
}
