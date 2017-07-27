<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\GuideDevice;
use Tests\TestCases\ApiTestCase;

class GuideDevicesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return GuideDevice::class;
    }

    protected function getRoute()
    {
        return '/guide-devices';
    }

    protected function getStoreData()
    {
        return [
            'name' => 'John Doe',
        ];
    }

    protected function getUpdateData()
    {
        return [
            'name' => 'John Doe II',
        ];
    }

    public function testGetWithImages()
    {
        $this->post(self::ROUTE_PREFIX . '/guide-devices/with-images');
        $this->assertResponseOk();
        $this->assertEquals(19, count($this->getResponseData()));
        $expectedFirst = [
            'name' => 'EMA',
            'id' => 16,
            'value' => 0,
            'imagePath' => 'dental_device_16.jpg',
        ];
        $this->assertEquals($expectedFirst, $this->getResponseData()[0]);
    }
}
