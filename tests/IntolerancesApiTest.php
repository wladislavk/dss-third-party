<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Intolerance;

class IntolerancesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/intolerances -> IntolerancesController@store method
     * 
     */
    public function testAddIntolerance()
    {
        $data = factory(Intolerance::class)->make()->toArray();

        $data['description'] = 'Test intolerance description';

        $this->post('/api/v1/intolerances', $data)
            ->seeInDatabase('dental_intolerance', ['description' => 'Test intolerance description'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/intolerances/{id} -> IntolerancesController@update method
     * 
     */
    public function testUpdateIntolerance()
    {
        $intoleranceTestRecord = factory(Intolerance::class)->create();

        $data = [
            'description' => 'updated intolerance description',
            'status'      => 8
        ];

        $this->put('/api/v1/intolerances/' . $intoleranceTestRecord->intoleranceid, $data)
            ->seeInDatabase('dental_intolerance', [
                'description' => 'updated intolerance description'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/intolerances/{id} -> IntolerancesController@destroy method
     * 
     */
    public function testDeleteIntolerance()
    {
        $intoleranceTestRecord = factory(Intolerance::class)->create();

        $this->delete('/api/v1/intolerances/' . $intoleranceTestRecord->intoleranceid)
            ->notSeeInDatabase('dental_intolerance', [
                'intoleranceid' => $intoleranceTestRecord->intoleranceid
            ])
            ->assertResponseOk();
    }
}
