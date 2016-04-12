<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\PlanText;

class PlanTextsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/plan-texts -> PlanTextsController@store method
     * 
     */
    public function testAddPlanText()
    {
        $data = factory(PlanText::class)->make()->toArray();

        $data['plan_text'] = 'added plan text';

        $this->post('/api/v1/plan-texts', $data)
            ->seeInDatabase('dental_plan_text', ['plan_text' => 'added plan text'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/plan-texts/{id} -> PlanTextsController@update method
     * 
     */
    public function testUpdatePlanText()
    {
        $planTextTestRecord = factory(PlanText::class)->create();

        $data = ['plan_text' => 'updated plan text'];

        $this->put('/api/v1/plan-texts/' . $planTextTestRecord->plan_textid, $data)
            ->seeInDatabase('dental_plan_text', ['plan_text' => 'updated plan text'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/plan-texts/{id} -> PlanTextsController@destroy method
     * 
     */
    public function testDeletePlanText()
    {
        $planTextTestRecord = factory(PlanText::class)->create();

        $this->delete('/api/v1/plan-texts/' . $planTextTestRecord->plan_textid)
            ->notSeeInDatabase('dental_plan_text', [
                'plan_textid' => $planTextTestRecord->plan_textid
            ])
            ->assertResponseOk();
    }
}
