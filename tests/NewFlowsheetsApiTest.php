<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\NewFlowsheet;

class NewFlowsheetsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/new-flowsheets -> NewFlowsheetsController@store method
     * 
     */
    public function testAddNewFlowsheet()
    {
        $data = factory(NewFlowsheet::class)->make()->toArray();

        $data['formid'] = 100;

        $this->post('/api/v1/new-flowsheets', $data)
            ->seeInDatabase('dental_flowsheet_new', ['formid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/new-flowsheets/{id} -> NewFlowsheetsController@update method
     * 
     */
    public function testUpdateNewFlowsheet()
    {
        $newFlowsheetTestRecord = factory(NewFlowsheet::class)->create();

        $data = [
            'patientid' => 100,
            'userid'    => 200
        ];

        $this->put('/api/v1/new-flowsheets/' . $newFlowsheetTestRecord->flowsheetid, $data)
            ->seeInDatabase('dental_flowsheet_new', ['patientid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/new-flowsheets/{id} -> NewFlowsheetsController@destroy method
     * 
     */
    public function testDeleteNewFlowsheet()
    {
        $newFlowsheetTestRecord = factory(NewFlowsheet::class)->create();

        $this->delete('/api/v1/new-flowsheets/' . $newFlowsheetTestRecord->flowsheetid)
            ->notSeeInDatabase('dental_flowsheet_new', [
                'flowsheetid' => $newFlowsheetTestRecord->flowsheetid
            ])
            ->assertResponseOk();
    }
}
