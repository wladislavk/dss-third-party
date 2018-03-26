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
}
