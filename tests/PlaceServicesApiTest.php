<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\PlaceService;

class PlaceServicesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/place-services -> PlaceServicesController@store method
     * 
     */
    public function testAddPlaceService()
    {
        $data = factory(PlaceService::class)->make()->toArray();

        $data['place_service'] = '123';

        $this->post('/api/v1/place-services', $data)
            ->seeInDatabase('dental_place_service', ['place_service' => '123'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/place-services/{id} -> PlaceServicesController@update method
     * 
     */
    public function testUpdatePlaceService()
    {
        $placeServiceTestRecord = factory(PlaceService::class)->create();

        $data = [
            'description' => 'updated place service',
            'status'      => 5
        ];

        $this->put('/api/v1/place-services/' . $placeServiceTestRecord->place_serviceid, $data)
            ->seeInDatabase('dental_place_service', ['status' => 5])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/place-services/{id} -> PlaceServicesController@destroy method
     * 
     */
    public function testDeletePlaceService()
    {
        $placeServiceTestRecord = factory(PlaceService::class)->create();

        $this->delete('/api/v1/place-services/' . $placeServiceTestRecord->place_serviceid)
            ->notSeeInDatabase('dental_place_service', [
                'place_serviceid' => $placeServiceTestRecord->place_serviceid
            ])
            ->assertResponseOk();
    }
}
