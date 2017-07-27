<?php
namespace Tests\Api;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\Login;
use Tests\TestCases\ApiTestCase;

class LoginsApiTest extends ApiTestCase
{
    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/logins -> LoginsController@store method
     * 
     */
    public function testAddLogin()
    {
        $data = factory(Login::class)->make()->toArray();

        $data['docid'] = 100;

        $this->post('/api/v1/logins', $data)
            ->seeInDatabase('dental_login', ['docid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/logins/{id} -> LoginsController@update method
     * 
     */
    public function testUpdateLogin()
    {
        $loginTestRecord = factory(Login::class)->create();

        $data = [
            'userid'      => 33,
            'login_date'  => Carbon::now(),
            'logout_date' => Carbon::now()->addHours(2)
        ];

        $this->put('/api/v1/logins/' . $loginTestRecord->loginid, $data)
            ->seeInDatabase('dental_login', ['userid' => 33])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/logins/{id} -> LoginsController@destroy method
     * 
     */
    public function testDeleteLogin()
    {
        $loginTestRecord = factory(Login::class)->create();

        $this->delete('/api/v1/logins/' . $loginTestRecord->loginid)
            ->notSeeInDatabase('dental_login', [
                'loginid' => $loginTestRecord->loginid
            ])
            ->assertResponseOk();
    }
}
