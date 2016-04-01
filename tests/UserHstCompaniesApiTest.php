<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\UserHstCompany;

class UserHstCompaniesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/user-hst-companies -> UserHstCompaniesController@store method
     * 
     */
    public function testAddUserHstCompany()
    {
        $data = factory(UserHstCompany::class)->make()->toArray();

        $data['userid'] = 100;

        $this->post('/api/v1/user-hst-companies', $data)
            ->seeInDatabase('dental_user_hst_company', ['userid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/user-hst-companies/{id} -> UserHstCompaniesController@update method
     * 
     */
    public function testUpdateUserHstCompany()
    {
        $userHstCompanyTestRecord = factory(UserHstCompany::class)->create();

        $data = ['companyid' => 100];

        $this->put('/api/v1/user-hst-companies/' . $userHstCompanyTestRecord->id, $data)
            ->seeInDatabase('dental_user_hst_company', ['companyid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/user-hst-companies/{id} -> UserHstCompaniesController@destroy method
     * 
     */
    public function testDeleteUserHstCompany()
    {
        $userHstCompanyTestRecord = factory(UserHstCompany::class)->create();

        $this->delete('/api/v1/user-hst-companies/' . $userHstCompanyTestRecord->id)
            ->notSeeInDatabase('dental_user_hst_company', [
                'id' => $userHstCompanyTestRecord->id
            ])
            ->assertResponseOk();
    }
}
