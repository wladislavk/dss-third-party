<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Dental\GuideDevice;
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
}
