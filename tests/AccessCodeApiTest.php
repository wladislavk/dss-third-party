<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccessCodeApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    protected $id;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/access-code -> Api/ApiAccessCodeController@store method
     * 
     */
    public function testAddAccessCode()
    {
        $data = [
            'access_code' => 'testAccessCode',
            'notes'       => 'additional test notes',
            'status'      => 1,
            'plan_id'     => 3
        ];

        $this->post('/api/v1/access-code', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => true])
            ->seeInDatabase('dental_access_codes', ['access_code' => 'testAccessCode']);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/access-code/{id} -> Api/ApiAccessCodeController@update method
     * 
     */
    public function testUpdateAccessCode()
    {
        $accessCodeTestRecord = factory(DentalSleepSolutions\Models\AccessCode::class)->create();

        $data = [
            'access_code' => 'updatedTestAccessCode',
            'status'      => 2
        ];

        $this->put('api/v1/access-code/' . $accessCodeTestRecord->id, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => true])
            ->seeInDatabase('dental_access_codes', ['access_code' => 'updatedTestAccessCode']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/access-code/{id} -> Api/ApiAccessCodeController@destroy method
     * 
     */
    public function testDeleteAccessCode()
    {
        $accessCodeTestRecord = factory(DentalSleepSolutions\Models\AccessCode::class)->create();

        $this->delete('/api/v1/access-code/' . $accessCodeTestRecord->id)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => true])
            ->notSeeInDatabase('dental_access_codes', ['id' => $accessCodeTestRecord->id]);
    }
}