<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Sleeplab;

class SleeplabsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/sleeplabs -> SleeplabsController@store method
     * 
     */
    public function testAddSleeplab()
    {
        $data = factory(Sleeplab::class)->make()->toArray();

        $data['docid'] = 100;

        $this->post('/api/v1/sleeplabs', $data)
            ->seeInDatabase('dental_sleeplab', ['docid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/sleeplabs/{id} -> SleeplabsController@update method
     * 
     */
    public function testUpdateSleeplab()
    {
        $sleeplabTestRecord = factory(Sleeplab::class)->create();

        $data = [
            'email'     => 'test@email.com',
            'lastname'  => 'Doe',
            'firstname' => 'John'
        ];

        $this->put('/api/v1/sleeplabs/' . $sleeplabTestRecord->sleeplabid, $data)
            ->seeInDatabase('dental_sleeplab', ['email' => 'test@email.com'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/sleeplabs/{id} -> SleeplabsController@destroy method
     * 
     */
    public function testDeleteSleeplab()
    {
        $sleeplabTestRecord = factory(Sleeplab::class)->create();

        $this->delete('/api/v1/sleeplabs/' . $sleeplabTestRecord->sleeplabid)
            ->notSeeInDatabase('dental_sleeplab', [
                'sleeplabid' => $sleeplabTestRecord->sleeplabid
            ])
            ->assertResponseOk();
    }
}
