<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class AdminCompanyApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    protected $id;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/admin-company -> Api/ApiAdminCompanyController@store method
     * 
     */
    public function testAddAdminCompany()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $data = [
            'adminid'   => 7,
            'companyid' => 14
        ];

        $this->post('/api/v1/admin-company', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('admin_company', ['companyid' => 14]);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/admin-company/{id} -> Api/ApiAdminCompanyController@update method
     * 
     */
    public function testUpdateAdminCompany()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $adminCompanyTestRecord = factory(DentalSleepSolutions\Eloquent\AdminCompany::class)->create();

        $data = [
            'companyid' => 15
        ];

        $this->put('/api/v1/admin-company/' . $adminCompanyTestRecord->id, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('admin_company', ['companyid' => 15]);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/admin-company/{id} -> Api/ApiAdminCompanyController@destroy method
     * 
     */
    public function testDeleteAdminCompany()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $adminCompanyTestRecord = factory(DentalSleepSolutions\Eloquent\AdminCompany::class)->create();

        $this->delete('/api/v1/admin-company/' . $adminCompanyTestRecord->id)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('admin_company', ['id' => $adminCompanyTestRecord->id]);
    }
}
