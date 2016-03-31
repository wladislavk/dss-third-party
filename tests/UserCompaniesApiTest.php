<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\UserCompany;

class UserCompaniesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/user-companies -> UserCompaniesController@store method
     * 
     */
    public function testAddUserCompany()
    {
        $data = factory(UserCompany::class)->make()->toArray();

        $data['userid'] = 100;

        $this->post('/api/v1/user-companies', $data)
            ->seeInDatabase('dental_user_company', ['userid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/user-companies/{id} -> UserCompaniesController@update method
     * 
     */
    public function testUpdateUserCompany()
    {
        $userCompanyTestRecord = factory(UserCompany::class)->create();

        $data = [
            'companyid' => 2,
            'userid'    => 7
        ];

        $this->put('/api/v1/user-companies/' . $userCompanyTestRecord->id, $data)
            ->seeInDatabase('dental_user_company', [
                'companyid' => 2
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/user-companies/{id} -> UserCompaniesController@destroy method
     * 
     */
    public function testDeleteUserCompany()
    {
        $userCompanyTestRecord = factory(UserCompany::class)->create();

        $this->delete('/api/v1/user-companies/' . $userCompanyTestRecord->id)
            ->notSeeInDatabase('dental_user_company', [
                'id' => $userCompanyTestRecord->id
            ])
            ->assertResponseOk();
    }
}