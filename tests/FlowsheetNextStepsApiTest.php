<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\FlowsheetNextStep;

class FlowsheetNextStepsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/flowsheet-next-steps -> FlowsheetNextStepsController@store method
     * 
     */
    public function testAddFlowsheetNextStep()
    {
        $data = factory(FlowsheetNextStep::class)->make()->toArray();

        $data['parent_id'] = 100;

        $this->post('/api/v1/flowsheet-next-steps', $data)
            ->seeInDatabase('dental_flowsheet_steps_next', ['parent_id' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/flowsheet-next-steps/{id} -> FlowsheetNextStepsController@update method
     * 
     */
    public function testUpdateFlowsheetNextStep()
    {
        $flowsheetNextStepTestRecord = factory(FlowsheetNextStep::class)->create();

        $data = ['child_id' => 100];

        $this->put('/api/v1/flowsheet-next-steps/' . $flowsheetNextStepTestRecord->id, $data)
            ->seeInDatabase('dental_flowsheet_steps_next', ['child_id' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/flowsheet-next-steps/{id} -> FlowsheetNextStepsController@destroy method
     * 
     */
    public function testDeleteFlowsheetNextStep()
    {
        $flowsheetNextStepTestRecord = factory(FlowsheetNextStep::class)->create();

        $this->delete('/api/v1/flowsheet-next-steps/' . $flowsheetNextStepTestRecord->id)
            ->notSeeInDatabase('dental_flowsheet_steps_next', [
                'id' => $flowsheetNextStepTestRecord->id
            ])
            ->assertResponseOk();
    }
}
