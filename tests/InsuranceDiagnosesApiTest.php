<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\InsDiagnosis;

class InsuranceDiagnosesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/insurance-diagnoses -> InsuranceDiagnosesController@store method
     * 
     */
    public function testAddInsuranceDiagnosis()
    {
        $data = factory(InsDiagnosis::class)->make()->toArray();

        $data['sortby'] = 100;

        $this->post('/api/v1/insurance-diagnoses', $data)
            ->seeInDatabase('dental_ins_diagnosis', ['sortby' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/insurance-diagnoses/{id} -> InsuranceDiagnosesController@update method
     * 
     */
    public function testUpdateInsuranceDiagnosis()
    {
        $insuranceDiagnosisTestRecord = factory(InsDiagnosis::class)->create();

        $data = [
            'description' => 'updated insurance diagnosis',
            'status'      => 5
        ];

        $this->put('/api/v1/insurance-diagnoses/' . $insuranceDiagnosisTestRecord->ins_diagnosisid, $data)
            ->seeInDatabase('dental_ins_diagnosis', ['description' => 'updated insurance diagnosis'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/insurance-diagnoses/{id} -> InsuranceDiagnosesController@destroy method
     * 
     */
    public function testDeleteInsuranceDiagnosis()
    {
        $insuranceDiagnosisTestRecord = factory(InsDiagnosis::class)->create();

        $this->delete('/api/v1/insurance-diagnoses/' . $insuranceDiagnosisTestRecord->ins_diagnosisid)
            ->notSeeInDatabase('dental_ins_diagnosis', [
                'ins_diagnosisid' => $insuranceDiagnosisTestRecord->ins_diagnosisid
            ])
            ->assertResponseOk();
    }
}
