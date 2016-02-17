<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\InsurancePreauth;

class InsurancePreauthApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/insurance-preauth -> InsurancePreauthController@store method
     * 
     */
    public function testAddInsurancePreauth()
    {
        $data = factory(InsurancePreauth::class)->make()->toArray();

        $data['doc_id'] = 7;

        $this->post('/api/v1/insurance-preauth', $data)
            ->seeInDatabase('dental_insurance_preauth', ['doc_id' => 7])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/insurance-preauth/{id} -> InsurancePreauthController@update method
     * 
     */
    public function testUpdateInsurancePreauth()
    {
        $insurancePreauthTestRecord = factory(InsurancePreauth::class)->create();

        $data = [
            'patient_id'        => 8,
            'ins_co'            => 'test company',
            'patient_firstname' => 'John',
            'patient_lastname'  => 'Doe'
        ];

        $this->put('/api/v1/insurance-preauth/' . $insurancePreauthTestRecord->id, $data)
            ->seeInDatabase('dental_insurance_preauth', ['patient_id' => 8])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/insurance-preauth/{id} -> InsurancePreauthController@destroy method
     * 
     */
    public function testDeleteInsurancePreauth()
    {
        $insurancePreauthTestRecord = factory(InsurancePreauth::class)->create();

        $this->delete('/api/v1/insurance-preauth/' . $insurancePreauthTestRecord->id)
            ->notSeeInDatabase('dental_insurance_preauth', [
                'id' => $insurancePreauthTestRecord->id
            ])
            ->assertResponseOk();
    }
}
