<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Plan;

class PlansApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/plans -> PlansController@store method
     * 
     */
    public function testAddPlan()
    {
        $data = factory(Plan::class)->make()->toArray();

        $data['name'] = 'added plan';

        $this->post('/api/v1/plans', $data)
            ->seeInDatabase('dental_plans', ['name' => 'added plan'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/plans/{id} -> PlansController@update method
     * 
     */
    public function testUpdatePlan()
    {
        $planTestRecord = factory(Plan::class)->create();

        $data = [
            'name'         => 'updated plan',
            'trial_period' => 54,
            'status'       => 5
        ];

        $this->put('/api/v1/plans/' . $planTestRecord->id, $data)
            ->seeInDatabase('dental_plans', ['trial_period' => 54])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/plans/{id} -> PlansController@destroy method
     * 
     */
    public function testDeletePlan()
    {
        $planTestRecord = factory(Plan::class)->create();

        $this->delete('/api/v1/plans/' . $planTestRecord->id)
            ->notSeeInDatabase('dental_plans', [
                'id' => $planTestRecord->id
            ])
            ->assertResponseOk();
    }
}
