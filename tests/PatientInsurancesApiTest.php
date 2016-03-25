<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\PatientInsurance;

class PatientInsurancesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/patient-insurances -> PatientInsurancesController@store method
     * 
     */
    public function testAddPatientInsurance()
    {
        $data = factory(PatientInsurance::class)->make()->toArray();

        $data['patientid'] = 100;

        $this->post('/api/v1/patient-insurances', $data)
            ->seeInDatabase('dental_patient_insurance', ['patientid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/patient-insurances/{id} -> PatientInsurancesController@update method
     * 
     */
    public function testUpdatePatientInsurance()
    {
        $patientInsuranceTestRecord = factory(PatientInsurance::class)->create();

        $data = [
            'patientid' => 85,
            'company'   => 'test company',
            'zip'       => 12345,
            'email'     => 'test@mail.com'
        ];

        $this->put('/api/v1/patient-insurances/' . $patientInsuranceTestRecord->id, $data)
            ->seeInDatabase('dental_patient_insurance', ['patientid' => 85])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/patient-insurances/{id} -> PatientInsurancesController@destroy method
     * 
     */
    public function testDeletePatientInsurance()
    {
        $patientInsuranceTestRecord = factory(PatientInsurance::class)->create();

        $this->delete('/api/v1/patient-insurances/' . $patientInsuranceTestRecord->id)
            ->notSeeInDatabase('dental_patient_insurance', [
                'id' => $patientInsuranceTestRecord->id
            ])
            ->assertResponseOk();
    }
}
