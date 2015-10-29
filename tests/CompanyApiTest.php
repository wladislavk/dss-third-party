<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigration;
use Illuminate\Foundation\Testing\DatabaseTransation;

class Company extends TestCase
{
    use WithoutMiddleware;

    protected $id;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/company -> Api/ApiCompanyController@store method
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

        $this->post('/api/v1/company', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => true])
            ->seeInDatabase('companies', ['name' => 'testName']);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/company/{id} -> Api/ApiCompanyController@update method
     * 
     */
    public function testUpdateCompany()
    {
        $companyTestRecord = \DentalSleepSolutions\Company::where('name', 'like', 'testName%')->firstOrFail();

        if ($companyTestRecord) {
            $data = [
                'name'   => 'testNameUpdated',
                'status' => 2
            ];

            $this->put('/api/v1/company/' . $companyTestRecord->id, $data)
                ->seeStatusCode(200)
                ->seeJsonContains(['status' => true])
                ->seeInDatabase('companies', ['name' => 'testNameUpdated']);
        }
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/company/{id} -> Api/ApiCompanyController@destroy method
     * 
     */
    public function testDeleteCompany()
    {
        $companyTestRecord = \DentalSleepSolutions\Company::where('name', 'like', 'testName%')->firstOrFail();

        if ($companyTestRecord) {
            $this->delete('/api/v1/company/' . $companyTestRecord->id)
                ->seeStatusCode(200)
                ->seeJsonContains(['status' => true])
                ->notSeeInDatabase('companies', ['name' => 'testNameUpdated']);
        }
    }
}
