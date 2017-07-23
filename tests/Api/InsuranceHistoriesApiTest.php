<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Dental\InsuranceHistory;
use Tests\TestCases\ApiTestCase;

class InsuranceHistoriesApiTest extends ApiTestCase
{
    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/insurance-histories -> InsuranceHistoriesController@store method
     * 
     */
    public function testAddInsuranceHistory()
    {
        $this->markTestSkipped('Column \'fo_paid_viewed\' does not exist in the DB');
        return;
        $data = factory(InsuranceHistory::class)->make()->toArray();

        $data['userid'] = 100;

        $this->post('/api/v1/insurance-histories', $data)
            ->seeInDatabase('dental_insurance_history', ['userid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/insurance-histories/{id} -> InsuranceHistoriesController@update method
     * 
     */
    public function testUpdateInsuranceHistory()
    {
        $this->markTestSkipped('Column \'fo_paid_viewed\' does not exist in the DB');
        return;

        $insuranceHistoryTestRecord = factory(InsuranceHistory::class)->create();

        $data = [
            'patientid'        => 7,
            'patient_lastname' => 'test lastname'
        ];

        $this->put('/api/v1/insurance-histories/' . $insuranceHistoryTestRecord->id, $data)
            ->seeInDatabase('dental_insurance_history', ['patient_lastname' => 'test lastname'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/insurance-histories/{id} -> InsuranceHistoriesController@destroy method
     * 
     */
    public function testDeleteInsuranceHistory()
    {
        $this->markTestSkipped('Column \'fo_paid_viewed\' does not exist in the DB');
        return;

        $insuranceHistoryTestRecord = factory(InsuranceHistory::class)->create();

        $this->delete('/api/v1/insurance-histories/' . $insuranceHistoryTestRecord->id)
            ->notSeeInDatabase('dental_insurance_history', [
                'id' => $insuranceHistoryTestRecord->id
            ])
            ->assertResponseOk();
    }
}
