<?php
namespace Tests\Api;

use DentalSleepSolutions\StaticClasses\Helpers;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use DentalSleepSolutions\Eloquent\Models\Dental\GuideSetting;
use Tests\TestCases\ApiTestCase;

class GuideSettingsApiTest extends ApiTestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/guide-settings -> GuideSettingsController@store method
     * 
     */
    public function testAddGuideSetting()
    {
        $data = [
            'name'         => 'John Doe',
            'setting_type' => 10,
            'range_start'  => 0,
            'range_end'    => 10,
            'rank'         => 5
        ];

        $this->post('/api/v1/guide-settings', $data);
        $this
            ->seeInDatabase('dental_device_guide_settings', [])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/guide-settings/{id} -> GuideSettingsController@update method
     * 
     */
    public function testUpdateGuideSetting()
    {
        $guideSettingTestRecord = factory(GuideSetting::class)->create();

        $data = [
            'name' => 'John Doe II',
            'rank' => 5
        ];

        $this->put('/api/v1/guide-settings/' . $guideSettingTestRecord->id, $data);
        $this
            ->seeInDatabase('dental_device_guide_settings', ['name' => 'John Doe II'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/guide-settings/{id} -> GuideSettingsController@destroy method
     * 
     */
    public function testDeleteGuideSetting()
    {
        $guideSettingTestRecord = factory(GuideSetting::class)->create();

        $this->delete('/api/v1/guide-settings/' . $guideSettingTestRecord->id);
        $this
            ->notSeeInDatabase('dental_device_guide_settings', ['id' => $guideSettingTestRecord->id])
            ->assertResponseOk();
    }

    public function testGetAllOrderBy()
    {
        $this->post('/api/v1/guide-settings/sort');
        $this->assertResponseOk();
        $result = json_decode($this->response->getContent(), true)['data'];
        $names = array_column($result, 'name');
        $sortedNames = Helpers::saneSort($names);
        $this->assertTrue($names === $sortedNames);
        $ids = array_column($result, 'id');
        $sortedIds = Helpers::saneSort($ids);
        $this->assertFalse($ids === $sortedIds);
    }
}
