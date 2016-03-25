<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\ScreenerEpworth;

class ScreenerEpworthApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/screener-epworth -> ScreenerEpworthController@store method
     * 
     */
    public function testAddScreenerEpworth()
    {
        $data = factory(ScreenerEpworth::class)->make()->toArray();

        $data['screener_id'] = 100;

        $this->post('/api/v1/screener-epworth', $data)
            ->seeInDatabase('dental_screener_epworth', ['screener_id' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/screener-epworth/{id} -> ScreenerEpworthController@update method
     * 
     */
    public function testUpdateScreenerEpworth()
    {
        $screenerEpworthTestRecord = factory(ScreenerEpworth::class)->create();

        $data = ['epworth_id' => 100];

        $this->put('/api/v1/screener-epworth/' . $screenerEpworthTestRecord->id, $data)
            ->seeInDatabase('dental_screener_epworth', ['epworth_id' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/screener-epworth/{id} -> ScreenerEpworthController@destroy method
     * 
     */
    public function testDeleteScreenerEpworth()
    {
        $screenerEpworthTestRecord = factory(ScreenerEpworth::class)->create();

        $this->delete('/api/v1/screener-epworth/' . $screenerEpworthTestRecord->id)
            ->notSeeInDatabase('dental_screener_epworth', [
                'id' => $screenerEpworthTestRecord->id
            ])
            ->assertResponseOk();
    }
}
