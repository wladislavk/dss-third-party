<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\SocialHistory;

class SocialHistoriesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/social-histories -> SocialHistoriesController@store method
     * 
     */
    public function testAddSocialHistory()
    {
        $data = factory(SocialHistory::class)->make()->toArray();

        $data['patientid'] = 100;

        $this->post('/api/v1/social-histories', $data)
            ->seeInDatabase('dental_q_page4', ['patientid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/social-histories/{id} -> SocialHistoriesController@update method
     * 
     */
    public function testUpdateSocialHistory()
    {
        $socialHistoryTestRecord = factory(SocialHistory::class)->create();

        $data = [
            'formid'               => 100,
            'additional_paragraph' => 'updated social history'
        ];

        $this->put('/api/v1/social-histories/' . $socialHistoryTestRecord->q_page4id, $data)
            ->seeInDatabase('dental_q_page4', ['formid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/social-histories/{id} -> SocialHistoriesController@destroy method
     * 
     */
    public function testDeleteSocialHistory()
    {
        $socialHistoryTestRecord = factory(SocialHistory::class)->create();

        $this->delete('/api/v1/social-histories/' . $socialHistoryTestRecord->q_page4id)
            ->notSeeInDatabase('dental_q_page4', [
                'q_page4id' => $socialHistoryTestRecord->q_page4id
            ])
            ->assertResponseOk();
    }
}
