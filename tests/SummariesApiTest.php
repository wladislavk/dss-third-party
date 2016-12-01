<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Summary;

class SummariesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/summaries -> SummariesController@store method
     * 
     */
    public function testAddSummary()
    {
        $data = factory(Summary::class)->make()->toArray();

        $data['formid'] = 100;

        $this->post('/api/v1/summaries', $data)
            ->seeInDatabase('dental_summary', ['formid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/summaries/{id} -> SummariesController@update method
     * 
     */
    public function testUpdateSummary()
    {
        $summaryTestRecord = factory(Summary::class)->create();

        $data = [
            'patientid'    => 123,
            'patient_name' => 'John Doe'
        ];

        $this->put('/api/v1/summaries/' . $summaryTestRecord->summaryid, $data)
            ->seeInDatabase('dental_summary', ['patientid' => 123])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/summaries/{id} -> SummariesController@destroy method
     * 
     */
    public function testDeleteSummary()
    {
        $summaryTestRecord = factory(Summary::class)->create();

        $this->delete('/api/v1/summaries/' . $summaryTestRecord->summaryid)
            ->notSeeInDatabase('dental_summary', [
                'summaryid' => $summaryTestRecord->summaryid
            ])
            ->assertResponseOk();
    }
}
