<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class AdminApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    protected $adminid;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/admin -> Api/ApiAdminController@post method
     * 
     */
    public function testAddAdmin()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

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

        $this->post('/api/v1/admin', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('admin', ['name' => 'PHPUnit admin']);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/admin/{adminId} -> Api/ApiAdminController@update method
     * 
     */
    public function testUpdateAdmin()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $adminTestRecord = factory(DentalSleepSolutions\Eloquent\Admin::class)->create();

        $data = [
            'name'       => 'PHPUnit updated admin',
            'first_name' => 'testFirstNameUpdated',
        ];

        $this->put('/api/v1/admin/' . $adminTestRecord->adminid, $data) 
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('admin', ['name' => 'PHPUnit updated admin']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/admin/{adminId} -> Api/ApiAdminController@destroy method
     * 
     */
    public function testDeleteAdmin()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $adminTestRecord = factory(DentalSleepSolutions\Eloquent\Admin::class)->create();

        $this->delete('/api/v1/admin/' . $adminTestRecord->adminid)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('admin', ['adminid' => $adminTestRecord->adminid]);
    }
}
