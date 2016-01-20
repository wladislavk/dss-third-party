<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\AccessCode;

class AccessCodesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/access-codes -> AccessCodesController@store method
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

        $this->post('/api/v1/access-codes', $data)
            ->seeInDatabase('dental_access_codes', ['access_code' => 'testAccessCode'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/access-codes/{id} -> AccessCodesController@update method
     * 
     */
    public function testUpdateAccessCode()
    {
        $accessCodeTestRecord = factory(AccessCode::class)->create();

        $data = [
            'access_code' => 'updatedTestAccessCode',
            'status'      => 2
        ];

        $this->put('api/v1/access-code/' . $accessCodeTestRecord->id, $data)
            ->seeInDatabase('dental_access_codes', ['access_code' => 'updatedTestAccessCode'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/access-codes/{id} -> AccessCodesController@destroy method
     * 
     */
    public function testDeleteAccessCode()
    {
        $accessCodeTestRecord = factory(AccessCode::class)->create();

        $this->delete('/api/v1/access-codes/' . $accessCodeTestRecord->id)
            ->notSeeInDatabase('dental_access_codes', ['id' => $accessCodeTestRecord->id])
            ->assertResponseOk();
    }
}
