<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\TypeService;

class TypeServicesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/type-services -> TypeServicesController@store method
     * 
     */
    public function testAddTypeService()
    {
        $data = factory(TypeService::class)->make()->toArray();

        $data['sortby'] = 100;

        $this->post('/api/v1/type-services', $data)
            ->seeInDatabase('dental_type_service', ['sortby' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/type-services/{id} -> TypeServicesController@update method
     * 
     */
    public function testUpdateTypeService()
    {
        $typeServiceTestRecord = factory(TypeService::class)->create();

        $data = [
            'description' => 'updated description',
            'sortby'      => 7,
            'status'      => 8
        ];

        $this->put('/api/v1/type-services/' . $typeServiceTestRecord->type_serviceid, $data)
            ->seeInDatabase('dental_type_service', [
                'description' => 'updated description'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/type-services/{id} -> TypeServicesController@destroy method
     * 
     */
    public function testDeleteTypeService()
    {
        $typeServiceTestRecord = factory(TypeService::class)->create();

        $this->delete('/api/v1/type-services/' . $typeServiceTestRecord->type_serviceid)
            ->notSeeInDatabase('dental_type_service', [
                'type_serviceid' => $typeServiceTestRecord->type_serviceid
            ])
            ->assertResponseOk();
    }
}
