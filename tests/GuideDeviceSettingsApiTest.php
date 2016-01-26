<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\GuideDeviceSetting;

class GuideDeviceSettingsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/guide-device-settings -> GuideDeviceSettingsController@store method
     * 
     */
    public function testAddCharge()
    {
        $data = [
            'device_id'  => 10,
            'setting_id' => 10,
            'value'      => 10
        ];

        $this->post('/api/v1/guide-device-settings', $data)
            ->seeInDatabase('dental_device_guide_device_setting', ['device_id'  => 10])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/guide-device-settings/{id} -> GuideDeviceSettingsController@update method
     * 
     */
    public function testUpdateCharge()
    {
        $guideDeviceSettingTestRecord = factory(GuideDeviceSetting::class)->create();

        $data = [
            'value' => 100
        ];

        $this->put('/api/v1/guide-device-settings/' . $guideDeviceSettingTestRecord->id, $data)
            ->seeInDatabase('dental_device_guide_device_setting', ['value' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/guide-device-settings/{id} -> GuideDeviceSettingsController@destroy method
     * 
     */
    public function testDeleteCharge()
    {
        $guideDeviceSettingTestRecord = factory(GuideDeviceSetting::class)->create();

        $this->delete('/api/v1/guide-device-settings/' . $guideDeviceSettingTestRecord->id)
            ->notSeeInDatabase('dental_device_guide_device_setting', [
                'id' => $guideDeviceSettingTestRecord->id
            ])
            ->assertResponseOk();
    }
} 
