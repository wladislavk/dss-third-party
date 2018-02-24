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
        $impressions = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
            12 => 0,
            13 => 0,
        ];
        $options = [
            1 => 1,
            2 => 1,
            3 => 1,
            4 => 1,
            5 => 1,
            6 => 1,
            7 => 1,
            8 => 1,
            9 => 1,
            10 => 1,
            11 => 1,
            12 => 1,
            13 => 1,
        ];
        $queryString = '';
        foreach ($impressions as $key => $impression) {
            $queryString .= "impressions[$key]=$impression&";
        }
        foreach ($options as $optionKey => $option) {
            $queryString .= "options[$optionKey]=$option&";
        }
        $queryString = substr($queryString, 0, strlen($queryString) - 1);
        $this->get(self::ROUTE_PREFIX . '/guide-devices/with-images?' . $queryString);
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
