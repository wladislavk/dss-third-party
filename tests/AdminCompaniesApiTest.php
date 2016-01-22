<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\AdminCompany;

class AdminCompaniesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/admin-companies -> AdminCompaniesController@store method
     * 
     */
    public function testAddAdminCompany()
    {
        $data = [
            'adminid'   => 7,
            'companyid' => 14
        ];

        $this->post('/api/v1/admin-companies', $data)
            ->seeInDatabase('admin_company', ['companyid' => 14])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/admin-companies/{id} -> AdminCompaniesController@update method
     * 
     */
    public function testUpdateAdminCompany()
    {
        $adminCompanyTestRecord = factory(AdminCompany::class)->create();

        $data = [
            'companyid' => 15
        ];

        $this->put('/api/v1/admin-companies/' . $adminCompanyTestRecord->id, $data)
            ->seeInDatabase('admin_company', ['companyid' => 15])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/admin-companies/{id} -> AdminCompaniesController@destroy method
     * 
     */
    public function testDeleteAdminCompany()
    {
        $adminCompanyTestRecord = factory(AdminCompany::class)->create();

        $this->delete('/api/v1/admin-companies/' . $adminCompanyTestRecord->id)
            ->notSeeInDatabase('admin_company', ['id' => $adminCompanyTestRecord->id])
            ->assertResponseOk();
    }
}
