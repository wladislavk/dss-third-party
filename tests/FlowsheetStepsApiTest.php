<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\FlowsheetStep;

class FlowsheetStepsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/flowsheet-steps -> FlowsheetStepsController@store method
     * 
     */
    public function testAddFlowsheetStep()
    {
        $data = factory(FlowsheetStep::class)->make()->toArray();

        $data['section'] = 100;

        $this->post('/api/v1/flowsheet-steps', $data)
            ->seeInDatabase('dental_flowsheet_steps', ['section' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/flowsheet-steps/{id} -> FlowsheetStepsController@update method
     * 
     */
    public function testUpdateFlowsheetStep()
    {
        $flowsheetStepTestRecord = factory(FlowsheetStep::class)->create();

        $data = [
            'name'    => 'updated flowsheet step',
            'section' => 123
        ];

        $this->put('/api/v1/flowsheet-steps/' . $flowsheetStepTestRecord->id, $data)
            ->seeInDatabase('dental_flowsheet_steps', ['section' => 123])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/flowsheet-steps/{id} -> FlowsheetStepsController@destroy method
     * 
     */
    public function testDeleteFlowsheetStep()
    {
        $flowsheetStepTestRecord = factory(FlowsheetStep::class)->create();

        $this->delete('/api/v1/flowsheet-steps/' . $flowsheetStepTestRecord->id)
            ->notSeeInDatabase('dental_flowsheet_steps', [
                'id' => $flowsheetStepTestRecord->id
            ])
            ->assertResponseOk();
    }
}
