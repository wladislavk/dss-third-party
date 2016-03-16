<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Screener;

class ScreenersApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/screeners -> ScreenersController@store method
     * 
     */
    public function testAddScreener()
    {
        $data = factory(Screener::class)->make()->toArray();

        $data['docid'] = 100;

        $this->post('/api/v1/screeners', $data)
            ->seeInDatabase('dental_screener', ['docid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/screeners/{id} -> ScreenersController@update method
     * 
     */
    public function testUpdateScreener()
    {
        $screenerTestRecord = factory(Screener::class)->create();

        $data = [
            'userid'     => 100,
            'first_name' => 'John',
            'last_name'  => 'Doe'
        ];

        $this->put('/api/v1/screeners/' . $screenerTestRecord->id, $data)
            ->seeInDatabase('dental_screener', ['userid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/screeners/{id} -> ScreenersController@destroy method
     * 
     */
    public function testDeleteScreener()
    {
        $screenerTestRecord = factory(Screener::class)->create();

        $this->delete('/api/v1/screeners/' . $screenerTestRecord->id)
            ->notSeeInDatabase('dental_screener', [
                'id' => $screenerTestRecord->id
            ])
            ->assertResponseOk();
    }
}
