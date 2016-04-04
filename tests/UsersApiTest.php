<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\User;

class UsersApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/users -> UsersController@store method
     * 
     */
    public function testAddUser()
    {
        $data = factory(User::class)->make()->toArray();

        $data['docid'] = 100;

        $this->post('/api/v1/users', $data)
            ->seeInDatabase('dental_users', ['docid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/users/{id} -> UsersController@update method
     * 
     */
    public function testUpdateUser()
    {
        $userTestRecord = factory(User::class)->create();

        $data = [
            'docid'    => 876,
            'username' => 'John Doe',
            'zip'      => '12345'
        ];

        $this->put('/api/v1/users/' . $userTestRecord->userid, $data)
            ->seeInDatabase('dental_users', ['docid' => 876])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/users/{id} -> UsersController@destroy method
     * 
     */
    public function testDeleteUser()
    {
        $userTestRecord = factory(User::class)->create();

        $this->delete('/api/v1/users/' . $userTestRecord->userid)
            ->notSeeInDatabase('dental_users', [
                'userid' => $userTestRecord->userid
            ])
            ->assertResponseOk();
    }
}
