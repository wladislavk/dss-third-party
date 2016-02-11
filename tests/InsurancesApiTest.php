<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Insurance;

class InsurancesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/insurances -> InsurancesController@store method
     * 
     */
    public function testAddInsurance()
    {
        $data = factory(Insurance::class)->make()->toArray();

        $data['userid'] = 100;

        $this->post('/api/v1/insurances', $data)
            ->seeInDatabase('dental_insurance', ['userid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/insurances/{id} -> InsurancesController@update method
     * 
     */
    public function testUpdateInsurance()
    {
        $insuranceTestRecord = factory(Insurance::class)->create();

        $data = [
            'patient_firstname' => 'updated patient firstname',
            'userid'            => 7,
            'docid'             => 8
        ];

        $this->put('/api/v1/insurances/' . $insuranceTestRecord->insuranceid, $data)
            ->seeInDatabase('dental_insurance', [
                'patient_firstname' => 'updated patient firstname'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/insurances/{id} -> InsurancesController@destroy method
     * 
     */
    public function testDeleteInsurance()
    {
        $insuranceTestRecord = factory(Insurance::class)->create();

        $this->delete('/api/v1/insurances/' . $insuranceTestRecord->insuranceid)
            ->notSeeInDatabase('dental_insurance', [
                'insuranceid' => $insuranceTestRecord->insuranceid
            ])
            ->assertResponseOk();
    }
}
