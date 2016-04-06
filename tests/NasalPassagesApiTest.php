<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\NasalPassage;

class NasalPassagesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/nasal-passages -> NasalPassagesController@store method
     * 
     */
    public function testAddNasalPassage()
    {
        $data = factory(NasalPassage::class)->make()->toArray();

        $data['status'] = 9;

        $this->post('/api/v1/nasal-passages', $data)
            ->seeInDatabase('dental_nasal_passages', ['status' => 9])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/nasal-passages/{id} -> NasalPassagesController@update method
     * 
     */
    public function testUpdateNasalPassage()
    {
        $nasalPassageTestRecord = factory(NasalPassage::class)->create();

        $data = [
            'description' => 'updated description',
            'status'      => 8
        ];

        $this->put('/api/v1/nasal-passages/' . $nasalPassageTestRecord->nasal_passagesid, $data)
            ->seeInDatabase('dental_nasal_passages', [
                'description' => 'updated description'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/nasal-passages/{id} -> NasalPassagesController@destroy method
     * 
     */
    public function testDeleteNasalPassage()
    {
        $nasalPassageTestRecord = factory(NasalPassage::class)->create();

        $this->delete('/api/v1/nasal-passages/' . $nasalPassageTestRecord->nasal_passagesid)
            ->notSeeInDatabase('dental_nasal_passages', [
                'nasal_passagesid' => $nasalPassageTestRecord->nasal_passagesid
            ])
            ->assertResponseOk();
    }
}