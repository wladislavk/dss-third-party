<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\GuideSetting;

class GuideSettingsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/guide-settings -> GuideSettingsController@store method
     * 
     */
    public function testAddCharge()
    {
        $data = [
            'name'         => 'John Doe',
            'setting_type' => 10,
            'range_start'  => 0,
            'range_end'    => 10,
            'rank'         => 5
        ];

        $this->post('/api/v1/guide-settings', $data)
            ->seeInDatabase('dental_device_guide_settings', [])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/guide-settings/{id} -> GuideSettingsController@update method
     * 
     */
    public function testUpdateCharge()
    {
        $guideSettingTestRecord = factory(GuideSetting::class)->create();

        $data = [
            'name' => 'John Doe II',
            'rank' => 5
        ];

        $this->put('/api/v1/guide-settings/' . $guideSettingTestRecord->id, $data)
            ->seeInDatabase('dental_device_guide_settings', ['name' => 'John Doe II'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/guide-settings/{id} -> GuideSettingsController@destroy method
     * 
     */
    public function testDeleteCharge()
    {
        $guideSettingTestRecord = factory(GuideSetting::class)->create();

        $this->delete('/api/v1/guide-settings/' . $guideSettingTestRecord->id)
            ->notSeeInDatabase('dental_device_guide_settings', ['id' => $guideSettingTestRecord->id])
            ->assertResponseOk();
    }
}