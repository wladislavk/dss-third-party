<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\HealthHistory;

class HealthHistoriesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/health-histories -> HealthHistoriesController@store method
     * 
     */
    public function testAddHealthHistory()
    {
        $data = factory(HealthHistory::class)->make()->toArray();

        $data['patientid'] = 100;

        $this->post('/api/v1/health-histories', $data)
            ->seeInDatabase('dental_q_page3', ['patientid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/health-histories/{id} -> HealthHistoriesController@update method
     * 
     */
    public function testUpdateHealthHistory()
    {
        $healthHistoryTestRecord = factory(HealthHistory::class)->create();

        $data = [
            'formid'               => 100,
            'additional_paragraph' => 'updated additional paragraph for hh'
        ];

        $this->put('/api/v1/health-histories/' . $healthHistoryTestRecord->q_page3id, $data)
            ->seeInDatabase('dental_q_page3', ['formid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/health-histories/{id} -> HealthHistoriesController@destroy method
     * 
     */
    public function testDeleteHealthHistory()
    {
        $healthHistoryTestRecord = factory(HealthHistory::class)->create();

        $this->delete('/api/v1/health-histories/' . $healthHistoryTestRecord->q_page3id)
            ->notSeeInDatabase('dental_q_page3', [
                'q_page3id' => $healthHistoryTestRecord->q_page3id
            ])
            ->assertResponseOk();
    }
}
