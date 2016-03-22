<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\GuideSettingOption;

class GuideSettingOptionsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/guide-setting-options -> GuideSettingOptionsController@store method
     * 
     */
    public function testAddGuideSettingOption()
    {
        $data = [
            'option_id'  => 10,
            'setting_id' => 10,
            'label'      => 'test'
        ];

        $this->post('/api/v1/guide-setting-options', $data)
            ->seeInDatabase('dental_device_guide_setting_options', ['setting_id' => 10])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/guide-setting-options/{id} -> GuideSettingOptionsController@update method
     * 
     */
    public function testUpdateGuideSettingOption()
    {
        $guideSettingOptionTestRecord = factory(GuideSettingOption::class)->create();

        $data = [
            'label' => 'updated test'
        ];

        $this->put('/api/v1/guide-setting-options/' . $guideSettingOptionTestRecord->id, $data)
            ->seeInDatabase('dental_device_guide_setting_options', ['label' => 'updated test'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/guide-setting-options/{id} -> GuideSettingOptionsController@destroy method
     * 
     */
    public function testDeleteGuideSettingOption()
    {
        $guideSettingOptionTestRecord = factory(GuideSettingOption::class)->create();

        $this->delete('/api/v1/guide-setting-options/' . $guideSettingOptionTestRecord->id)
            ->notSeeInDatabase('dental_device_guide_setting_options', [
                'id' => $guideSettingOptionTestRecord->id
            ])
            ->assertResponseOk();
    }
}
