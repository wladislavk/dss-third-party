<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Palpation;

class PalpationApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/palpation -> PalpationController@store method
     * 
     */
    public function testAddPalpation()
    {
        $data = factory(Palpation::class)->make()->toArray();

        $data['palpation'] = 'new palpation';

        $this->post('/api/v1/palpation', $data)
            ->seeInDatabase('dental_palpation', ['palpation' => 'new palpation'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/palpation/{id} -> PalpationController@update method
     * 
     */
    public function testUpdatePalpation()
    {
        $palpationTestRecord = factory(Palpation::class)->create();

        $data = [
            'description' => 'updated palpation',
            'sortby'      => 333
        ];

        $this->put('/api/v1/palpation/' . $palpationTestRecord->palpationid, $data)
            ->seeInDatabase('dental_palpation', ['sortby' => 333])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/palpation/{id} -> PalpationController@destroy method
     * 
     */
    public function testDeletePalpation()
    {
        $palpationTestRecord = factory(Palpation::class)->create();

        $this->delete('/api/v1/palpation/' . $palpationTestRecord->palpationid)
            ->notSeeInDatabase('dental_palpation', [
                'palpationid' => $palpationTestRecord->palpationid
            ])
            ->assertResponseOk();
    }
}
