<?php
namespace Tests\Api;

use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCases\ApiTestCase;
use DentalSleepSolutions\Eloquent\Dental\Device;

class DevicesApiTest extends ApiTestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/device -> Api/ApiDeviceController@store method
     *
     */
    public function testAddDevice()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $data = [
            'device'     => 'some test device',
            'status'     => 10,
            'image_path' => 'dental_device_555.gif'
        ];

        $this->post('/api/v1/devices/', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_device', ['image_path' => 'dental_device_555.gif']);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/device/{id} -> Api/ApiDeviceController@update method
     *
     */
    public function testUpdateDevice()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $deviceTestRecord = factory(Device::class)->create();

        $data = [
            'device' => 'some updated test device',
            'status' => 10
        ];

        $this->put('/api/v1/devices/' . $deviceTestRecord->deviceid, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_device', ['device' => 'some updated test device']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/device/{id} -> Api/ApiDeviceController@destroy method
     *
     */
    public function testDeleteDevice()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $deviceTestRecord = factory(Device::class)->create();

        $this->delete('/api/v1/devices/' . $deviceTestRecord->deviceid)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('dental_device', ['deviceid' => $deviceTestRecord->deviceid]);
    }
}
