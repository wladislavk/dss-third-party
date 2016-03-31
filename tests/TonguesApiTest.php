<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Tongue;

class TonguesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/tongues -> TonguesController@store method
     * 
     */
    public function testAddTongue()
    {
        $data = factory(Tongue::class)->make()->toArray();

        $data['tongue'] = 'added tongue';

        $this->post('/api/v1/tongues', $data)
            ->seeInDatabase('dental_tongue', ['tongue' => 'added tongue'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/tongues/{id} -> TonguesController@update method
     * 
     */
    public function testUpdateTongue()
    {
        $tongueTestRecord = factory(Tongue::class)->create();

        $data = [
            'description' => 'updated tongue',
            'status'      => 8
        ];

        $this->put('/api/v1/tongues/' . $tongueTestRecord->tongueid, $data)
            ->seeInDatabase('dental_tongue', ['description' => 'updated tongue'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/tongues/{id} -> TonguesController@destroy method
     * 
     */
    public function testDeleteTongue()
    {
        $tongueTestRecord = factory(Tongue::class)->create();

        $this->delete('/api/v1/tongues/' . $tongueTestRecord->tongueid)
            ->notSeeInDatabase('dental_tongue', [
                'tongueid' => $tongueTestRecord->tongueid
            ])
            ->assertResponseOk();
    }
}
