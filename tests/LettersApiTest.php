<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Letter;

class LettersApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/letters -> LettersController@store method
     * 
     */
    public function testAddLetter()
    {
        $data = factory(Letter::class)->make()->toArray();

        $data['patientid'] = 100;

        $this->post('/api/v1/letters', $data)
            ->seeInDatabase('dental_letters', ['patientid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/letters/{id} -> LettersController@update method
     * 
     */
    public function testUpdateLetter()
    {
        $letterTestRecord = factory(Letter::class)->create();

        $data = [
            'patientid'   => 33,
            'send_method' => 'email',
            'status'      => 0,
            'templateid'  => 12
        ];

        $this->put('/api/v1/letters/' . $letterTestRecord->letterid, $data)
            ->seeInDatabase('dental_letters', ['patientid' => 33])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/letters/{id} -> LettersController@destroy method
     * 
     */
    public function testDeleteLetter()
    {
        $letterTestRecord = factory(Letter::class)->create();

        $this->delete('/api/v1/letters/' . $letterTestRecord->letterid)
            ->notSeeInDatabase('dental_letters', [
                'letterid' => $letterTestRecord->letterid
            ])
            ->assertResponseOk();
    }
}
