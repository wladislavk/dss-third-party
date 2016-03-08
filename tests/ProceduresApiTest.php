<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Procedure;

class ProceduresApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/procedures -> ProceduresController@store method
     * 
     */
    public function testAddProcedure()
    {
        $data = factory(Procedure::class)->make()->toArray();

        $data['patientid'] = 100;

        $this->post('/api/v1/procedures', $data)
            ->seeInDatabase('dental_procedure', ['patientid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/procedures/{id} -> ProceduresController@update method
     * 
     */
    public function testUpdateProcedure()
    {
        $procedureTestRecord = factory(Procedure::class)->create();

        $data = [
            'insuranceid' => 152,
            'docid'       => 28
        ];

        $this->put('/api/v1/procedures/' . $procedureTestRecord->procedureid, $data)
            ->seeInDatabase('dental_procedure', ['insuranceid' => 152])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/procedures/{id} -> ProceduresController@destroy method
     * 
     */
    public function testDeleteProcedure()
    {
        $procedureTestRecord = factory(Procedure::class)->create();

        $this->delete('/api/v1/procedures/' . $procedureTestRecord->procedureid)
            ->notSeeInDatabase('dental_procedure', [
                'procedureid' => $procedureTestRecord->procedureid
            ])
            ->assertResponseOk();
    }
}
