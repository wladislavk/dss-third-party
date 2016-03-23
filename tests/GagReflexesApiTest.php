<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\GagReflex;

class GagReflexesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/gag-reflexes -> GagReflexesController@store method
     * 
     */
    public function testAddGagReflex()
    {
        $data = factory(GagReflex::class)->make()->toArray();

        $data['sortby'] = 100;

        $this->post('/api/v1/gag-reflexes', $data)
            ->seeInDatabase('dental_gag_reflex', ['sortby' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/gag-reflexes/{id} -> GagReflexesController@update method
     * 
     */
    public function testUpdateGagReflex()
    {
        $gagReflexTestRecord = factory(GagReflex::class)->create();

        $data = [
            'description' => 'updated gag reflex',
            'status'      => 1
        ];

        $this->put('/api/v1/gag-reflexes/' . $gagReflexTestRecord->gag_reflexid, $data)
            ->seeInDatabase('dental_gag_reflex', ['description' => 'updated gag reflex'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/gag-reflexes/{id} -> GagReflexesController@destroy method
     * 
     */
    public function testDeleteGagReflex()
    {
        $gagReflexTestRecord = factory(GagReflex::class)->create();

        $this->delete('/api/v1/gag-reflexes/' . $gagReflexTestRecord->gag_reflexid)
            ->notSeeInDatabase('dental_gag_reflex', [
                'gag_reflexid' => $gagReflexTestRecord->gag_reflexid
            ])
            ->assertResponseOk();
    }
}
