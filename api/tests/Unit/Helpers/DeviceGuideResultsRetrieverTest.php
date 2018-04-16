<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\DeviceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingRepository;
use DentalSleepSolutions\Helpers\DeviceInfoGetter;
use DentalSleepSolutions\Helpers\DeviceGuideResultsRetriever;
use DentalSleepSolutions\Structs\DeviceInfo;
use DentalSleepSolutions\Eloquent\Models\Dental\Device;
use DentalSleepSolutions\Eloquent\Models\Dental\GuideSetting;
use DentalSleepSolutions\Constants\DeviceSettingTypes;
use Illuminate\Database\Eloquent\Collection;
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
    const CHECKED_OPTIONS = [1, 2, 3];
    const IMPRESSIONS = [3];

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
        $deviceInfoGetter = $this->mockDeviceInfoGetter();

        $this->deviceGuideResultsRetriever = new DeviceGuideResultsRetriever(
            $deviceRepository,
            $guideSettingRepository,
            $deviceInfoGetter
        );
    }

    public function testGetWithoutDevices()
    {
        $this->isEmptyDevices = true;
        $devicesArray = $this->deviceGuideResultsRetriever->get(self::IMPRESSIONS, self::CHECKED_OPTIONS);
        $this->assertEquals([], $devicesArray);
    }

    public function testGetWithDeviceInfo()
    {
        $devicesArray = $this->deviceGuideResultsRetriever->get(self::IMPRESSIONS, self::CHECKED_OPTIONS);
        $expectedDevicesArray = [self::DEVICE_INFO_2, self::DEVICE_INFO_1];
        $this->assertEquals($expectedDevicesArray, $devicesArray);
    }

    public function testGetWithoutDeviceInfo()
    {
        $this->withDeviceInfo = false;
        $devicesArray = $this->deviceGuideResultsRetriever->get(self::IMPRESSIONS, self::CHECKED_OPTIONS);
        $this->assertEquals([], $devicesArray);
    }

    private function mockDeviceRepository()
    {
        /** @var DeviceRepository|MockInterface $deviceRepository */
        $deviceRepository = \Mockery::mock(DeviceRepository::class);
        $deviceRepository->shouldReceive('get')
            ->andReturnUsing([$this, 'getDeviceFakeData']);
        return $deviceRepository;
    }

    private function mockGuideSettingRepository()
    {
        /** @var GuideSettingRepository|MockInterface $guideSettingRepository */
        $guideSettingRepository = \Mockery::mock(GuideSettingRepository::class);
        $guideSettingRepository->shouldReceive('getSettingsByType')
            ->andReturnUsing([$this, 'getGuideSettingFakeData']);
        return $guideSettingRepository;
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

    public function getFakeDeviceInfo($device)
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

    public function getGuideSettingFakeData()
    {
        $guideSettings = [
            [
                'id' => 3,
                'setting_type' => DeviceSettingTypes::DSS_DEVICE_SETTING_TYPE_RANGE,
                'value' => 200,
            ],
        ];

        return $guideSettings;
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
