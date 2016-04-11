<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\MissingTooth;

class MissingTeethApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/missing-teeth -> MissingTeethController@store method
     * 
     */
    public function testAddMissingTooth()
    {
        $data = factory(MissingTooth::class)->make()->toArray();

        $data['userid'] = 100;

        $this->post('/api/v1/missing-teeth', $data)
            ->seeInDatabase('dental_missing', ['userid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/missing-teeth/{id} -> MissingTeethController@update method
     * 
     */
    public function testUpdateMissingTooth()
    {
        $missingToothTestRecord = factory(MissingTooth::class)->create();

        $data = [
            'pck'    => '~17~',
            'userid' => 7
        ];

        $this->put('/api/v1/missing-teeth/' . $missingToothTestRecord->missingid, $data)
            ->seeInDatabase('dental_missing', [
                'pck' => '~17~'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/missing-teeth/{id} -> MissingTeethController@destroy method
     * 
     */
    public function testDeleteMissingTooth()
    {
        $missingToothTestRecord = factory(MissingTooth::class)->create();

        $this->delete('/api/v1/missing-teeth/' . $missingToothTestRecord->missingid)
            ->notSeeInDatabase('dental_missing', [
                'missingid' => $missingToothTestRecord->missingid
            ])
            ->assertResponseOk();
    }
}