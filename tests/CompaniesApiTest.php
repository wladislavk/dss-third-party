<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Company;

class Company extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/companies -> CompaniesController@store method
     * 
     */
    public function testAddCompany()
    {
        $data = [
            'name'   => 'testName',
            'add1'   => 'testAdd1',
            'add2'   => 'testAdd2',
            'city'   => 'testCity',
            'state'  => 'testState',
            'zip'    => '12345',
            'status' => 0
        ];

        $this->post('/api/v1/companies', $data)
            ->seeInDatabase('companies', ['name' => 'testName'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/companies/{id} -> CompaniesController@update method
     * 
     */
    public function testUpdateCompany()
    {
        $companyTestRecord = factory(Company::class)->create();

        $data = [
            'name'   => 'testNameUpdated',
            'status' => 2
        ];

        $this->put('/api/v1/companies/' . $companyTestRecord->id, $data)
            ->seeInDatabase('companies', ['name' => 'testNameUpdated'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/companies/{id} -> CompaniesController@destroy method
     * 
     */
    public function testDeleteCompany()
    {
        $companyTestRecord = factory(Company::class)->create();

        $this->delete('/api/v1/company/' . $companyTestRecord->id)
            ->notSeeInDatabase('companies', ['id' => $companyTestRecord->id])
            ->assertResponseOk();
    }
}
