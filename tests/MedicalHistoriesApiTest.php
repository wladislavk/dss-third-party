<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\MedicalHistory;

class MedicalHistoriesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/medical-histories -> MedicalHistoriesController@store method
     * 
     */
    public function testAddMedicalHistory()
    {
        $data = factory(MedicalHistory::class)->make()->toArray();

        $data['status'] = 7;

        $this->post('/api/v1/medical-histories', $data)
            ->seeInDatabase('dental_history', ['status' => 7])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/medical-histories/{id} -> MedicalHistoriesController@update method
     * 
     */
    public function testUpdateMedicalHistory()
    {
        $medicalHistoryTestRecord = factory(MedicalHistory::class)->create();

        $data = [
            'description' => 'updated medical history',
            'sortby'      => 100
        ];

        $this->put('/api/v1/medical-histories/' . $medicalHistoryTestRecord->historyid, $data)
            ->seeInDatabase('dental_history', ['description' => 'updated medical history'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/medical-histories/{id} -> MedicalHistoriesController@destroy method
     * 
     */
    public function testDeleteMedicalHistory()
    {
        $medicalHistoryTestRecord = factory(MedicalHistory::class)->create();

        $this->delete('/api/v1/medical-histories/' . $medicalHistoryTestRecord->historyid)
            ->notSeeInDatabase('dental_history', [
                'historyid' => $medicalHistoryTestRecord->historyid
            ])
            ->assertResponseOk();
    }
}
