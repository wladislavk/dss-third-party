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
        $settings = '13_1,3_1,7_1,5_1,2_1,6_1,1_1,4_1,11_1,12_1';
        $this->get(sprintf('%s/guide-devices/with-images?settings=%s', self::ROUTE_PREFIX, $settings));
        $this->assertResponseOk();
        $this->assertEquals(19, count($this->getResponseData()));
        $expectedFirst = [
            'id' => 13,
            'name' => 'SUAD Ultra Elite',
            'value' => 34,
            'image_path' => 'dental_device_13.gif',
        ];
        $this->assertEquals($expectedFirst, $this->getResponseData()[0]);
    }
}
