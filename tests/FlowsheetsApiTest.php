<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Flowsheet;

class FlowsheetsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/flowsheets -> FlowsheetsController@store method
     * 
     */
    public function testAddFlowsheet()
    {
        $data = factory(Flowsheet::class)->make()->toArray();

        $data['userid'] = 100;

        $this->post('/api/v1/flowsheets', $data)
            ->seeInDatabase('dental_flowsheet', ['userid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/flowsheets/{id} -> FlowsheetsController@update method
     * 
     */
    public function testUpdateFlowsheet()
    {
        $flowsheetTestRecord = factory(Flowsheet::class)->create();

        $data = [
            'select_type' => 'updated select type',
            'userid'      => 7
        ];

        $this->put('/api/v1/flowsheets/' . $flowsheetTestRecord->flowsheetid, $data)
            ->seeInDatabase('dental_flowsheet', [
                'select_type' => 'updated select type'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/flowsheets/{id} -> FlowsheetsController@destroy method
     * 
     */
    public function testDeleteFlowsheet()
    {
        $flowsheetTestRecord = factory(Flowsheet::class)->create();

        $this->delete('/api/v1/flowsheets/' . $flowsheetTestRecord->flowsheetid)
            ->notSeeInDatabase('dental_flowsheet', [
                'flowsheetid' => $flowsheetTestRecord->flowsheetid
            ])
            ->assertResponseOk();
    }
}
