<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\SoftPalate;

class SoftPalatesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/soft-palates -> SoftPalatesController@store method
     * 
     */
    public function testAddSoftPalate()
    {
        $data = factory(SoftPalate::class)->make()->toArray();

        $data['sortby'] = 100;

        $this->post('/api/v1/soft-palates', $data)
            ->seeInDatabase('dental_soft_palate', ['sortby' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/soft-palates/{id} -> SoftPalatesController@update method
     * 
     */
    public function testUpdateSoftPalate()
    {
        $softPalateTestRecord = factory(SoftPalate::class)->create();

        $data = [
            'description' => 'updated soft palate',
            'status'      => 8
        ];

        $this->put('/api/v1/soft-palates/' . $softPalateTestRecord->soft_palateid, $data)
            ->seeInDatabase('dental_soft_palate', ['status' => 8])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/soft-palates/{id} -> SoftPalatesController@destroy method
     * 
     */
    public function testDeleteSoftPalate()
    {
        $softPalateTestRecord = factory(SoftPalate::class)->create();

        $this->delete('/api/v1/soft-palates/' . $softPalateTestRecord->soft_palateid)
            ->notSeeInDatabase('dental_soft_palate', [
                'soft_palateid' => $softPalateTestRecord->soft_palateid
            ])
            ->assertResponseOk();
    }
}
