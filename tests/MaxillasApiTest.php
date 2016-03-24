<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Maxilla;

class MaxillasApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/maxillas -> MaxillasController@store method
     * 
     */
    public function testAddMaxilla()
    {
        $data = factory(Maxilla::class)->make()->toArray();

        $data['status'] = 7;

        $this->post('/api/v1/maxillas', $data)
            ->seeInDatabase('dental_maxilla', ['status' => 7])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/maxillas/{id} -> MaxillasController@update method
     * 
     */
    public function testUpdateMaxilla()
    {
        $maxillaTestRecord = factory(Maxilla::class)->create();

        $data = [
            'description' => 'updated maxilla',
            'sortby'      => 123
        ];

        $this->put('/api/v1/maxillas/' . $maxillaTestRecord->maxillaid, $data)
            ->seeInDatabase('dental_maxilla', ['sortby' => 123])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/maxillas/{id} -> MaxillasController@destroy method
     * 
     */
    public function testDeleteMaxilla()
    {
        $maxillaTestRecord = factory(Maxilla::class)->create();

        $this->delete('/api/v1/maxillas/' . $maxillaTestRecord->maxillaid)
            ->notSeeInDatabase('dental_maxilla', [
                'maxillaid' => $maxillaTestRecord->maxillaid
            ])
            ->assertResponseOk();
    }
}
