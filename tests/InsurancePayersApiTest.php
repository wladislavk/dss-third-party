<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\InsurancePayer;

class InsurancePayersApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/insurance-payers -> InsurancePayersController@store method
     * 
     */
    public function testAddInsurancePayer()
    {
        $data = factory(InsurancePayer::class)->make()->toArray();

        $data['payer_id'] = '12345';

        $this->post('/api/v1/insurance-payers', $data)
            ->seeInDatabase('dental_ins_payer', ['payer_id' => '12345'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/insurance-payers/{id} -> InsurancePayersController@update method
     * 
     */
    public function testUpdateInsurancePayer()
    {
        $insurancePayerTestRecord = factory(InsurancePayer::class)->create();

        $data = ['name' => 'updated insurance payer'];

        $this->put('/api/v1/insurance-payers/' . $insurancePayerTestRecord->id, $data)
            ->seeInDatabase('dental_ins_payer', ['name' => 'updated insurance payer'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/insurance-payers/{id} -> InsurancePayersController@destroy method
     * 
     */
    public function testDeleteInsurancePayer()
    {
        $insurancePayerTestRecord = factory(InsurancePayer::class)->create();

        $this->delete('/api/v1/insurance-payers/' . $insurancePayerTestRecord->id)
            ->notSeeInDatabase('dental_ins_payer', [
                'id' => $insurancePayerTestRecord->id
            ])
            ->assertResponseOk();
    }
}
