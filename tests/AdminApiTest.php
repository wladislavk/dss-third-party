<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminApiTest extends TestCase
{
    use WithoutMiddleware;

    protected $adminid;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/admin -> Api/ApiAdminController@post method
     * 
     */
    public function testAddAdmin()
    {
        $data = [
            'name'               => 'PHPUnit admin',
            'username'           => 'testAdmin',
            'password'           => 'testPassword',
            'status'             => 2,
            'admin_access'       => 4,
            'email'              => 'test@email.com',
            'first_name'         => 'testFirstName',
            'last_name'          => 'testLastName'
        ];

        $this->post('/api/v1/admin', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => true])
            ->seeInDatabase('admin', ['name' => 'PHPUnit admin']);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/admin/{adminId} -> Api/ApiAdminController@update method
     * 
     */
    public function testUpdateAdmin()
    {
        $adminTestRecord = \DentalSleepSolutions\Admin::where('name', 'like', 'PHPUnit%')->firstOrFail();

        if ($adminTestRecord) {
            $data = [
                'name'               => 'PHPUnit updated admin',
                'first_name'         => 'testFirstNameUpdated',
            ];

            $this->put('/api/v1/admin/' . $adminTestRecord->adminid, $data)
                ->seeStatusCode(200)
                ->seeJsonContains(['status' => true])
                ->seeInDatabase('admin', ['name' => 'PHPUnit updated admin']);
        }
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/admin/{adminId} -> Api/ApiAdminController@destroy method
     * 
     */
    public function testDeleteAdmin()
    {
        $adminTestRecord = \DentalSleepSolutions\Admin::where('name', 'like', 'PHPUnit%')->firstOrFail();

        if ($adminTestRecord) {
            $this->delete('/api/v1/admin/' . $adminTestRecord->adminid)
                ->seeStatusCode(200)
                ->seeJsonContains(['status' => true])
                ->notSeeInDatabase('admin', ['name' => 'PHPUnit updated admin']);
        }
    }
}
