<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Location;

class LocationsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/locations -> LocationsController@store method
     * 
     */
    public function testAddLocation()
    {
        $data = factory(Location::class)->make()->toArray();

        $data['docid'] = 100;

        $this->post('/api/v1/locations', $data)
            ->seeInDatabase('dental_locations', ['docid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/locations/{id} -> LocationsController@update method
     * 
     */
    public function testUpdateLocation()
    {
        $locationTestRecord = factory(Location::class)->create();

        $data = [
            'location' => 'test location',
            'docid'    => 33,
            'name'     => 'John Doe'
        ];

        $this->put('/api/v1/locations/' . $locationTestRecord->id, $data)
            ->seeInDatabase('dental_locations', ['docid' => 33])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/locations/{id} -> LocationsController@destroy method
     * 
     */
    public function testDeleteLocation()
    {
        $locationTestRecord = factory(Location::class)->create();

        $this->delete('/api/v1/locations/' . $locationTestRecord->id)
            ->notSeeInDatabase('dental_locations', [
                'id' => $locationTestRecord->id
            ])
            ->assertResponseOk();
    }
}
