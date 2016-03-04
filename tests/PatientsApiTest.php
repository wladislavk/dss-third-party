<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Patient;

class PatientsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/patients -> PatientsController@store method
     * 
     */
    public function testAddPatient()
    {
        $data = factory(Patient::class)->make()->toArray();

        $data['member_no'] = 'test member number';

        $this->post('/api/v1/patients', $data)
            ->seeInDatabase('dental_patients', ['member_no' => 'test member number'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/patients/{id} -> PatientsController@update method
     * 
     */
    public function testUpdatePatient()
    {
        $patientTestRecord = factory(Patient::class)->create();

        $data = [
            'lastname'  => 'Doe',
            'firstname' => 'John',
            'add1'      => 'some address',
            'userid'    => 253
        ];

        $this->put('/api/v1/patients/' . $patientTestRecord->patientid, $data)
            ->seeInDatabase('dental_patients', ['userid' => 253])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/patients/{id} -> PatientsController@destroy method
     * 
     */
    public function testDeletePatient()
    {
        $patientTestRecord = factory(Patient::class)->create();

        $this->delete('/api/v1/patients/' . $patientTestRecord->patientid)
            ->notSeeInDatabase('dental_patients', [
                'patientid' => $patientTestRecord->patientid
            ])
            ->assertResponseOk();
    }
}
