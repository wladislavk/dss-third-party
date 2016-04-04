<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Uvula;

class UvulasApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/uvulas -> UvulasController@store method
     * 
     */
    public function testAddUvula()
    {
        $data = factory(Uvula::class)->make()->toArray();

        $data['sortby'] = 100;

        $this->post('/api/v1/uvulas', $data)
            ->seeInDatabase('dental_uvula', ['sortby' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/uvulas/{id} -> UvulasController@update method
     * 
     */
    public function testUpdateUvula()
    {
        $uvulaTestRecord = factory(Uvula::class)->create();

        $data = [
            'description' => 'updated uvula description',
            'sortby'      => 7
        ];

        $this->put('/api/v1/uvulas/' . $uvulaTestRecord->uvulaid, $data)
            ->seeInDatabase('dental_uvula', [
                'description' => 'updated uvula description'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/uvulas/{id} -> UvulasController@destroy method
     * 
     */
    public function testDeleteUvula()
    {
        $uvulaTestRecord = factory(Uvula::class)->create();

        $this->delete('/api/v1/uvulas/' . $uvulaTestRecord->uvulaid)
            ->notSeeInDatabase('dental_uvula', [
                'uvulaid' => $uvulaTestRecord->uvulaid
            ])
            ->assertResponseOk();
    }
}
