<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Symptom;

class SymptomsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/symptoms -> SymptomsController@store method
     * 
     */
    public function testAddSymptom()
    {
        $data = factory(Symptom::class)->make()->toArray();

        $data['patientid'] = 100;

        $this->post('/api/v1/symptoms', $data)
            ->seeInDatabase('dental_q_page1', ['patientid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/symptoms/{id} -> SymptomsController@update method
     * 
     */
    public function testUpdateSymptom()
    {
        $symptomTestRecord = factory(Symptom::class)->create();

        $data = [
            'formid'  => 458,
            'plan_no' => 'updated plan number'
        ];

        $this->put('/api/v1/symptoms/' . $symptomTestRecord->q_page1id, $data)
            ->seeInDatabase('dental_q_page1', ['formid' => 458])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/symptoms/{id} -> SymptomsController@destroy method
     * 
     */
    public function testDeleteSymptom()
    {
        $symptomTestRecord = factory(Symptom::class)->create();

        $this->delete('/api/v1/symptoms/' . $symptomTestRecord->q_page1id)
            ->notSeeInDatabase('dental_q_page1', [
                'q_page1id' => $symptomTestRecord->q_page1id
            ])
            ->assertResponseOk();
    }
}
