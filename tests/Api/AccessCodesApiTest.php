<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Dental\AccessCode;
use Tests\TestCases\ApiTestCase;

class AccessCodesApiTest extends ApiTestCase
{
    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/access-codes -> AccessCodesController@store method
     * 
     */
    public function testAddAccessCode()
    {
        $newCode = 'new' . date('Y-m-d H:i:s');
        $data = [
            'access_code' => $newCode,
            'notes'       => 'additional test notes',
            'status'      => 1,
            'plan_id'     => 3
        ];

        $this->post('/api/v1/access-codes', $data)
            ->seeInDatabase('dental_access_codes', ['access_code' => $newCode])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/access-codes/{id} -> AccessCodesController@update method
     * 
     */
    public function testUpdateAccessCode()
    {
        /** @var AccessCode $accessCodeTestRecord */
        $accessCodeTestRecord = factory(AccessCode::class)->create();
        $originalCode = $accessCodeTestRecord->access_code;
        $newCode = 'update' . date('Y-m-d H:i:s');

        $data = [
            'access_code' => $newCode,
            'status'      => 2,
        ];

        $this->put('api/v1/access-codes/' . $accessCodeTestRecord->id, $data);
        $this
            ->seeInDatabase('dental_access_codes', ['access_code' => $newCode])
            ->assertResponseOk();
        $this->put('api/v1/access-codes/' . $accessCodeTestRecord->id, ['access_code' => $originalCode]);
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
