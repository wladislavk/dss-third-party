<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\InsuranceStatusHistory;

class InsuranceStatusHistoriesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/insurance-status-histories -> InsuranceStatusHistoriesController@store method
     * 
     */
    public function testAddInsuranceStatusHistory()
    {
        $data = factory(InsuranceStatusHistory::class)->make()->toArray();

        $data['insuranceid'] = 100;

        $this->post('/api/v1/insurance-status-histories', $data)
            ->seeInDatabase('dental_insurance_status_history', ['insuranceid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/insurance-status-histories/{id} -> InsuranceStatusHistoriesController@update method
     * 
     */
    public function testUpdateInsuranceStatusHistor()
    {
        $insuranceStatusHistoryTestRecord = factory(InsuranceStatusHistory::class)->create();

        $data = [
            'insuranceid' => 7,
            'status'      => 7
        ];

        $this->put('/api/v1/insurance-status-histories/' . $insuranceStatusHistoryTestRecord->id, $data)
            ->seeInDatabase('dental_insurance_status_history', [
                'insuranceid' => 7
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/insurance-status-histories/{id} -> InsuranceStatusHistoriesController@destroy method
     * 
     */
    public function testDeleteInsuranceStatusHistor()
    {
        $insuranceStatusHistoryTestRecord = factory(InsuranceStatusHistory::class)->create();

        $this->delete('/api/v1/insurance-status-histories/' . $insuranceStatusHistoryTestRecord->id)
            ->notSeeInDatabase('dental_insurance_status_history', [
                'id' => $insuranceStatusHistoryTestRecord->id
            ])
            ->assertResponseOk();
    }
}
