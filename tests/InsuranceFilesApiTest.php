<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\InsuranceFile;

class InsuranceFilesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/insurance-files -> InsuranceFilesController@store method
     * 
     */
    public function testAddInsuranceFile()
    {
        $data = factory(InsuranceFile::class)->make()->toArray();

        $data['claimid'] = 100;

        $this->post('/api/v1/insurance-files', $data)
            ->seeInDatabase('dental_insurance_file', ['claimid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/insurance-files/{id} -> InsuranceFilesController@update method
     * 
     */
    public function testUpdateInsuranceFile()
    {
        $insuranceFileTestRecord = factory(InsuranceFile::class)->create();

        $data = [
            'description' => 'updated insurance file',
            'status'      => 8
        ];

        $this->put('/api/v1/insurance-files/' . $insuranceFileTestRecord->id, $data)
            ->seeInDatabase('dental_insurance_file', [
                'description' => 'updated insurance file'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/insurance-files/{id} -> InsuranceFilesController@destroy method
     * 
     */
    public function testDeleteInsuranceFile()
    {
        $insuranceFileTestRecord = factory(InsuranceFile::class)->create();

        $this->delete('/api/v1/insurance-files/' . $insuranceFileTestRecord->id)
            ->notSeeInDatabase('dental_insurance_file', [
                'id' => $insuranceFileTestRecord->id
            ])
            ->assertResponseOk();
    }
}
