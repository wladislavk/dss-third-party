<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Mandible;

class MandiblesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/mandibles -> MandiblesController@store method
     * 
     */
    public function testAddMandible()
    {
        $data = factory(Mandible::class)->make()->toArray();

        $data['status'] = 7;

        $this->post('/api/v1/mandibles', $data)
            ->seeInDatabase('dental_mandible', ['status' => 7])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/mandibles/{id} -> MandiblesController@update method
     * 
     */
    public function testUpdateMandible()
    {
        $mandibleTestRecord = factory(Mandible::class)->create();

        $data = [
            'description' => 'updated mandible',
            'sortby'      => 123
        ];

        $this->put('/api/v1/mandibles/' . $mandibleTestRecord->mandibleid, $data)
            ->seeInDatabase('dental_mandible', ['sortby' => 123])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/mandibles/{id} -> MandiblesController@destroy method
     * 
     */
    public function testDeleteMandible()
    {
        $mandibleTestRecord = factory(Mandible::class)->create();

        $this->delete('/api/v1/mandibles/' . $mandibleTestRecord->mandibleid)
            ->notSeeInDatabase('dental_mandible', [
                'mandibleid' => $mandibleTestRecord->mandibleid
            ])
            ->assertResponseOk();
    }
}
