<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\PatientContact;

class PatientContactsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/patient-contacts -> PatientContactsController@store method
     * 
     */
    public function testAddPatientContact()
    {
        $data = factory(PatientContact::class)->make()->toArray();

        $data['patientid'] = 100;

        $this->post('/api/v1/patient-contacts', $data)
            ->seeInDatabase('dental_patient_contacts', ['patientid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/patient-contacts/{id} -> PatientContactsController@update method
     * 
     */
    public function testUpdatePatientContact()
    {
        $patientContactTestRecord = factory(PatientContact::class)->create();

        $data = [
            'patientid' => 54,
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'zip'       => 12345
        ];

        $this->put('/api/v1/patient-contacts/' . $patientContactTestRecord->id, $data)
            ->seeInDatabase('dental_patient_contacts', ['patientid' => 54])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/patient-contacts/{id} -> PatientContactsController@destroy method
     * 
     */
    public function testDeletePatientContact()
    {
        $patientContactTestRecord = factory(PatientContact::class)->create();

        $this->delete('/api/v1/patient-contacts/' . $patientContactTestRecord->id)
            ->notSeeInDatabase('dental_patient_contacts', [
                'id' => $patientContactTestRecord->id
            ])
            ->assertResponseOk();
    }
}
