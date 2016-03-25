<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\PreviousTreatment;

class PreviousTreatmentsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/previous-treatments -> PreviousTreatmentsController@store method
     * 
     */
    public function testAddPreviousTreatment()
    {
        $data = factory(PreviousTreatment::class)->make()->toArray();

        $data['patientid'] = 100;

        $this->post('/api/v1/previous-treatments', $data)
            ->seeInDatabase('dental_q_page2', ['patientid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/previous-treatments/{id} -> PreviousTreatmentsController@update method
     * 
     */
    public function testUpdatePreviousTreatment()
    {
        $previousTreatmentTestRecord = factory(PreviousTreatment::class)->create();

        $data = [
            'formid'            => 153,
            'other_intolerance' => 'updated intolerance'
        ];

        $this->put('/api/v1/previous-treatments/' . $previousTreatmentTestRecord->q_page2id, $data)
            ->seeInDatabase('dental_q_page2', ['formid' => 153])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/previous-treatments/{id} -> PreviousTreatmentsController@destroy method
     * 
     */
    public function testDeletePreviousTreatment()
    {
        $previousTreatmentTestRecord = factory(PreviousTreatment::class)->create();

        $this->delete('/api/v1/previous-treatments/' . $previousTreatmentTestRecord->q_page2id)
            ->notSeeInDatabase('dental_q_page2', [
                'q_page2id' => $previousTreatmentTestRecord->q_page2id
            ])
            ->assertResponseOk();
    }
}
