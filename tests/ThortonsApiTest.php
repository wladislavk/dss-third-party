<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Thorton;

class ThortonsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/thortons -> ThortonsController@store method
     * 
     */
    public function testAddThorton()
    {
        $data = factory(Thorton::class)->make()->toArray();

        $data['formid'] = 100;

        $this->post('/api/v1/thortons', $data)
            ->seeInDatabase('dental_thorton', ['formid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/thortons/{id} -> ThortonsController@update method
     * 
     */
    public function testUpdateThorton()
    {
        $thortonTestRecord = factory(Thorton::class)->create();

        $data = [
            'patientid' => 200,
            'tot_score' => 1234
        ];

        $this->put('/api/v1/thortons/' . $thortonTestRecord->thortonid, $data)
            ->seeInDatabase('dental_thorton', ['patientid' => 200])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/thortons/{id} -> ThortonsController@destroy method
     * 
     */
    public function testDeleteThorton()
    {
        $thortonTestRecord = factory(Thorton::class)->create();

        $this->delete('/api/v1/thortons/' . $thortonTestRecord->thortonid)
            ->notSeeInDatabase('dental_thorton', [
                'thortonid' => $thortonTestRecord->thortonid
            ])
            ->assertResponseOk();
    }
}
