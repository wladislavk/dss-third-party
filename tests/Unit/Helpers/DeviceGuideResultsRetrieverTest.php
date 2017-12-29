<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\DeviceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingRepository;
use DentalSleepSolutions\Helpers\DeviceSettingsConverter;
use DentalSleepSolutions\Helpers\DeviceInfoGetter;
use DentalSleepSolutions\Helpers\DeviceGuideResultsRetriever;
use DentalSleepSolutions\Structs\DeviceInfo;
use DentalSleepSolutions\Eloquent\Models\Dental\Device;
use DentalSleepSolutions\Structs\DeviceSettings;
use DentalSleepSolutions\Eloquent\Models\Dental\GuideSetting;
use DentalSleepSolutions\Constants\DeviceSettingTypes;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class DeviceGuideResultsRetrieverTest extends UnitTestCase
{
    const DEVICE_INFO_1 = [
        'id' => 1,
        'name' => 'test name',
        'value' => 40.5,
        'image_path' => 'test image path',
    ];
    const DEVICE_INFO_2 = [
        'id' => 2,
        'name' => 'test name2',
        'value' => 80.5,
        'image_path' => 'test image path2',
    ];
    const DEVICE_SETTINGS = '1_1,2_1,3_1_1';

    /**
     * @var DeviceGuideResultsRetriever
     */
    private $deviceGuideResultsRetriever;

    /**
     * @var boolean
     */
    private $isEmptyDevices;

    /**
     * @var boolean
     */
    private $withDeviceInfo;

    public function setUp()
    {
        $this->isEmptyDevices = false;
        $this->withDeviceInfo = true;

        $deviceRepository = $this->mockDeviceRepository();
        $guideSettingRepository = $this->mockGuideSettingRepository();
        $deviceSettingsConverter = $this->mockDeviceSettingsConverter();
        $deviceInfoGetter = $this->mockDeviceInfoGetter();

        $this->deviceGuideResultsRetriever = new DeviceGuideResultsRetriever(
            $deviceRepository,
            $guideSettingRepository,
            $deviceSettingsConverter,
            $deviceInfoGetter
        );
    }

    public function testGetWithoutDevices()
    {
        $this->isEmptyDevices = true;
        $devicesArray = $this->deviceGuideResultsRetriever->get(self::DEVICE_SETTINGS);

        $this->assertEquals([], $devicesArray);
    }

    public function testGetWithDeviceInfo()
    {
        $devicesArray = $this->deviceGuideResultsRetriever->get(self::DEVICE_SETTINGS);

        $expectedDevicesArray = [self::DEVICE_INFO_2, self::DEVICE_INFO_1];
        $this->assertEquals($expectedDevicesArray, $devicesArray);
    }

    public function testGetWithoutDeviceInfo()
    {
        $this->withDeviceInfo = false;
        $devicesArray = $this->deviceGuideResultsRetriever->get(self::DEVICE_SETTINGS);

        $this->assertEquals([], $devicesArray);
    }

    private function mockDeviceRepository()
    {
        /** @var DeviceRepository|MockInterface $deviceRepository */
        $deviceRepository = \Mockery::mock(DeviceRepository::class);
        $deviceRepository->shouldReceive('getWithFilter')
            ->andReturnUsing([$this, 'getDeviceFakeData']);
        return $deviceRepository;
    }

    private function mockGuideSettingRepository()
    {
        /** @var GuideSettingRepository|MockInterface $guideSettingRepository */
        $guideSettingRepository = \Mockery::mock(GuideSettingRepository::class);
        $guideSettingRepository->shouldReceive('getSettingType')
            ->andReturnUsing([$this, 'getGuideSettingFakeData']);
        return $guideSettingRepository;
    }

    private function mockDeviceSettingsConverter()
    {
        /** @var DeviceSettingsConverter|MockInterface $deviceSettingsConverter */
        $deviceSettingsConverter = \Mockery::mock(DeviceSettingsConverter::class);
        $deviceSettingsConverter->shouldReceive('convertSettings')
            ->with(self::DEVICE_SETTINGS)
            ->andReturnUsing([$this, 'getDeviceSettingsStructFakeData']);

        return $deviceSettingsConverter;
    }

    private function mockDeviceInfoGetter()
    {
        /** @var DeviceInfoGetter|MockInterface $deviceInfoGetter */
        $deviceInfoGetter = \Mockery::mock(DeviceInfoGetter::class);
        $deviceInfoGetter
            ->shouldReceive('get')
            ->andReturnUsing([$this, 'getFakeDeviceInfo'])
        ;

        return $deviceInfoGetter;
    }

    public function getFakeDeviceInfo($device, $guideSettings, $settings)
    {
        if ($this->withDeviceInfo) {
            $deviceInfo = new DeviceInfo();
            $deviceInfo->id = $device->deviceid;
            $deviceInfo->name = $device->device;
            $deviceInfo->imagePath = $device->image_path;

            $deviceInfo->value = self::DEVICE_INFO_1['value'];
            if ($deviceInfo->id === self::DEVICE_INFO_2['id']) {
                $deviceInfo->value = self::DEVICE_INFO_2['value'];
            }

            return $deviceInfo;
        }

        return null;
    }

    public function getDeviceSettingsStructFakeData()
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

    public function getGuideSettingFakeData()
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

    public function getDeviceFakeData()
    {
        if ($this->isEmptyDevices) {
            return [];
        }

        $device1 = new Device();
        $device1->deviceid = self::DEVICE_INFO_1['id'];
        $device1->device = self::DEVICE_INFO_1['name'];
        $device1->image_path = self::DEVICE_INFO_1['image_path'];

        $device2 = new Device();
        $device2->deviceid = self::DEVICE_INFO_2['id'];
        $device2->device = self::DEVICE_INFO_2['name'];
        $device2->image_path = self::DEVICE_INFO_2['image_path'];

        return [$device1, $device2];
    }
}
