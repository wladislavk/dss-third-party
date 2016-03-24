<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Joint;

class JointsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/joints -> JointsController@store method
     * 
     */
    public function testAddJoint()
    {
        $data = factory(Joint::class)->make()->toArray();

        $data['joint'] = 'test add joint';

        $this->post('/api/v1/joints', $data)
            ->seeInDatabase('dental_joint', ['joint' => 'test add joint'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/joints/{id} -> JointsController@update method
     * 
     */
    public function testUpdateJoint()
    {
        $jointTestRecord = factory(Joint::class)->create();

        $data = [
            'joint'  => 'test updated joint',
            'status' => 8
        ];

        $this->put('/api/v1/joints/' . $jointTestRecord->jointid, $data)
            ->seeInDatabase('dental_joint', [
                'joint' => 'test updated joint'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/joints/{id} -> JointsController@destroy method
     * 
     */
    public function testDeleteJoint()
    {
        $jointTestRecord = factory(Joint::class)->create();

        $this->delete('/api/v1/joints/' . $jointTestRecord->jointid)
            ->notSeeInDatabase('dental_joint', [
                'jointid' => $jointTestRecord->jointid
            ])
            ->assertResponseOk();
    }
}
