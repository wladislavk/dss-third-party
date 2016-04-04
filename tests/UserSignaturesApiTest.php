<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\UserSignature;

class UserSignaturesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/user-signatures -> UserSignaturesController@store method
     * 
     */
    public function testAddUserSignature()
    {
        $data = factory(UserSignature::class)->make()->toArray();

        $data['user_id'] = 100;

        $this->post('/api/v1/user-signatures', $data)
            ->seeInDatabase('dental_user_signatures', ['user_id' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/user-signatures/{id} -> UserSignaturesController@update method
     * 
     */
    public function testUpdateUserSignature()
    {
        $userSignatureTestRecord  = factory(UserSignature::class)->create();

        $data = [
            'user_id'        => 7,
            'signature_json' => '{"lx":18,"ly":18,"mx":18,"my":18}'
        ];

        $this->put('/api/v1/user-signatures/' . $userSignatureTestRecord ->id, $data)
            ->seeInDatabase('dental_user_signatures', [
                'user_id' => 7
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/user-signatures/{id} -> UserSignaturesController@destroy method
     * 
     */
    public function testDeleteUserSignature()
    {
        $userSignatureTestRecord  = factory(UserSignature::class)->create();

        $this->delete('/api/v1/user-signatures/' . $userSignatureTestRecord ->id)
            ->notSeeInDatabase('dental_user_signatures', [
                'id' => $userSignatureTestRecord ->id
            ])
            ->assertResponseOk();
    }
}