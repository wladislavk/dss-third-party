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
        $expected = [
            [
                'id' => 13,
                'name' => 'SUAD Ultra Elite',
                'value' => 34,
                'image_path' => 'dental_device_13.gif',
            ],
            [
                'id' => 7,
                'name' => 'Narval',
                'value' => 33,
                'image_path' => 'dental_device_7.gif',
            ],
            [
                'id' => 2,
                'name' => 'Dorsal Hard',
                'value' => 33,
                'image_path' => 'dental_device_2.jpg',
            ],
            [
                'id' => 14,
                'name' => 'SUAD Hard',
                'value' => 33,
                'image_path' => 'dental_device_14.gif',
            ],
            [
                'id' => 15,
                'name' => 'SUAD Thermo',
                'value' => 33,
                'image_path' => 'dental_device_15.gif',
            ],
            [
                'id' => 1,
                'name' => 'Dorsal Flex',
                'value' => 30,
                'image_path' => 'dental_device_1.jpg',
            ],
            [
                'id' => 20,
                'name' => 'TAP 3 Durasoft',
                'value' => 29,
                'image_path' => 'dental_device_20.jpg',
            ],
            [
                'id' => 10,
                'name' => 'Full Breath',
                'value' => 28,
                'image_path' => 'dental_device_10.jpg',
            ],
            [
                'id' => 17,
                'name' => 'TAP Elite Thermacryl',
                'value' => 28,
                'image_path' => 'dental_device_17.jpg',
            ],
            [
                'id' => 3,
                'name' => 'Dorsal Reverse Flex',
                'value' => 27,
                'image_path' => 'dental_device_3.jpg',
            ],
            [
                'id' => 19,
                'name' => 'TAP 3 Thermacryl',
                'value' => 27,
                'image_path' => 'dental_device_19.jpg',
            ],
            [
                'id' => 16,
                'name' => 'EMA',
                'value' => 27,
                'image_path' => 'dental_device_16.jpg',
            ],
            [
                'id' => 18,
                'name' => 'TAP Elite Durasoft',
                'value' => 26,
                'image_path' => 'dental_device_18.jpg',
            ],
            [
                'id' => 9,
                'name' => 'Herbst',
                'value' => 26,
                'image_path' => 'dental_device_9.jpg',
            ],
            [
                'id' => 6,
                'name' => 'Dorsal Reverse Hard',
                'value' => 10,
                'image_path' => 'dental_device_6.jpg',
            ],
            [
                'id' => 12,
                'name' => 'Respire',
                'value' => 0,
                'image_path' => 'dental_device_12.jpg',
            ],
            [
                'id' => 11,
                'name' => 'Lamberg Sleepwell',
                'value' => 0,
                'image_path' => 'dental_device_11.png',
            ],
            [
                'id' => 8,
                'name' => 'PM Positioner Thermo',
                'value' => 0,
                'image_path' => 'dental_device_8.gif',
            ],
            [
                'id' => 21,
                'name' => 'None',
                'value' => 0,
                'image_path' => null,
            ],
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }

    public function testGetWithImagesAndImpressions()
    {
        $impressions = [
            1 => 0,
            2 => 0,
            3 => 1,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 1,
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
        $expectedFirst = [
            'id' => 13,
            'name' => 'SUAD Ultra Elite',
            'value' => 41.5,
            'image_path' => 'dental_device_13.gif',
        ];
        $this->assertEquals($expectedFirst, $this->getResponseData()[0]);
    }
}
