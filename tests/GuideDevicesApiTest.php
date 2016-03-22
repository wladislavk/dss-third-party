<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\GuideDevice;

class GuideDevicesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/guide-devices -> GuideDevicesController@store method
     * 
     */
    public function testAddGuideDevice()
    {
        $data = [
            'name' => 'John Doe'
        ];

        $this->post('/api/v1/guide-devices', $data)
            ->seeInDatabase('dental_device_guide_devices', ['name' => 'John Doe'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/guide-devices/{id} -> GuideDevicesController@update method
     * 
     */
    public function testUpdateGuideDevice()
    {
        $guideDeviceTestRecord = factory(GuideDevice::class)->create();

        $data = [
            'name' => 'John Doe II'
        ];

        $this->put('/api/v1/guide-devices/' . $guideDeviceTestRecord->id, $data)
            ->seeInDatabase('dental_device_guide_devices', ['name' => 'John Doe II'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/guide-devices/{id} -> GuideDevicesController@destroy method
     * 
     */
    public function testDeleteGuideDevice()
    {
        $guideDeviceTestRecord = factory(GuideDevice::class)->create();

        $this->delete('/api/v1/guide-devices/' . $guideDeviceTestRecord->id)
            ->notSeeInDatabase('dental_device_guide_devices', ['id' => $guideDeviceTestRecord->id])
            ->assertResponseOk();
    }
}
