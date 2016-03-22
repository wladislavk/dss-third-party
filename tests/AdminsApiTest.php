<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Admin;

class AdminsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/admins -> AdminsController@post method
     * 
     */
    public function testAddAdmin()
    {
        $data = [
            'name'               => 'PHPUnit admin',
            'username'           => 'testUsername',
            'password'           => 'testPassword',
            'status'             => 2,
            'admin_access'       => 4,
            'email'              => 'test@email.com',
            'first_name'         => 'testFirstName',
            'last_name'          => 'testLastName'
        ];

        $this->post('/api/v1/admins', $data)
            ->seeInDatabase('admin', ['name' => 'PHPUnit admin'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/admins/{adminId} -> AdminsController@update method
     * 
     */
    public function testUpdateAdmin()
    {
        $adminTestRecord = factory(Admin::class)->create();

        $data = [
            'name'       => 'PHPUnit updated admin',
            'first_name' => 'testFirstNameUpdated',
            'password'   => 'test'
        ];

        $this->put('/api/v1/admins/' . $adminTestRecord->adminid, $data)
            ->seeInDatabase('admin', ['name' => 'PHPUnit updated admin'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/admins/{adminId} -> AdminsController@destroy method
     * 
     */
    public function testDeleteAdmin()
    {
        $adminTestRecord = factory(Admin::class)->create();

        $this->delete('/api/v1/admins/' . $adminTestRecord->adminid)
            ->notSeeInDatabase('admin', ['adminid' => $adminTestRecord->adminid])
            ->assertResponseOk();
    }
}
