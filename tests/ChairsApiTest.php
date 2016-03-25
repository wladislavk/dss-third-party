<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Chair;

class ChairsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/chairs -> ChairsController@store method
     * 
     */
    public function testAddChair()
    {
        $data = factory(Chair::class)->make()->toArray();

        $data['docid'] = 100;

        $this->post('/api/v1/chairs', $data)
            ->seeInDatabase('dental_resources', ['docid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/chairs/{id} -> ChairsController@update method
     * 
     */
    public function testUpdateChair()
    {
        $insuranceTestRecord = factory(Chair::class)->create();

        $data = ['name' => 'updated chair'];

        $this->put('/api/v1/chairs/' . $insuranceTestRecord->id, $data)
            ->seeInDatabase('dental_resources', ['name' => 'updated chair'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/chairs/{id} -> ChairsController@destroy method
     * 
     */
    public function testDeleteChair()
    {
        $insuranceTestRecord = factory(Chair::class)->create();

        $this->delete('/api/v1/chairs/' . $insuranceTestRecord->id)
            ->notSeeInDatabase('dental_resources', [
                'id' => $insuranceTestRecord->id
            ])
            ->assertResponseOk();
    }
}
