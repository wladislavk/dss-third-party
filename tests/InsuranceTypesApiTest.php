<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\InsuranceType;

class InsuranceTypesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/insurance-types -> InsuranceTypesController@store method
     * 
     */
    public function testAddInsuranceType()
    {
        $data = factory(InsuranceType::class)->make()->toArray();

        $data['sortby'] = 100;

        $this->post('/api/v1/insurance-types', $data)
            ->seeInDatabase('dental_ins_type', ['sortby' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/insurance-types/{id} -> InsuranceTypesController@update method
     * 
     */
    public function testUpdateInsuranceType()
    {
        $insuranceTypeTestRecord = factory(InsuranceType::class)->create();

        $data = [
            'description' => 'updated insurance type',
            'status'      => 3
        ];

        $this->put('/api/v1/insurance-types/' . $insuranceTypeTestRecord->ins_typeid, $data)
            ->seeInDatabase('dental_ins_type', ['description' => 'updated insurance type'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/insurance-types/{id} -> InsuranceTypesController@destroy method
     * 
     */
    public function testDeleteInsuranceType()
    {
        $insuranceTypeTestRecord = factory(InsuranceType::class)->create();

        $this->delete('/api/v1/insurance-types/' . $insuranceTypeTestRecord->ins_typeid)
            ->notSeeInDatabase('dental_ins_type', [
                'ins_typeid' => $insuranceTypeTestRecord->ins_typeid
            ])
            ->assertResponseOk();
    }
}
