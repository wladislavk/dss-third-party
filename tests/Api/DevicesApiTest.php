<?php
namespace Tests\Api;

use Tests\TestCases\ApiTestCase;
use DentalSleepSolutions\Eloquent\Models\Dental\Device;

class DevicesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Device::class;
    }

    protected function getRoute()
    {
        return '/devices';
    }

    protected function getStoreData()
    {
        return [
            'device'     => 'some test device',
            'status'     => 10,
            'image_path' => 'dental_device_555.gif',
        ];
    }

    protected function getUpdateData()
    {
        return [
            'device' => 'some updated test device',
            'status' => 10,
        ];
    }

    public function testGetByStatus()
    {
        $this->get(self::ROUTE_PREFIX . '/devices/by-status');
        $this->assertResponseOk();
        $deviceIds = array_column($this->getResponseData(), 'deviceid');
        $expectedIds = [21, 1, 2, 20, 3, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19];
        $this->assertEquals($expectedIds, $deviceIds);
    }
}
