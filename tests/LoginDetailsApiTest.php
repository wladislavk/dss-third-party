<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\LoginDetail;

class LoginDetailsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/login-details -> LoginDetailsController@store method
     * 
     */
    public function testAddLoginDetail()
    {
        $data = factory(LoginDetail::class)->make()->toArray();

        $data['loginid'] = 100;

        $this->post('/api/v1/login-details', $data)
            ->seeInDatabase('dental_login_detail', ['loginid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/login-details/{id} -> LoginDetailsController@update method
     * 
     */
    public function testUpdateLoginDetail()
    {
        $loginDetailTestRecord = factory(LoginDetail::class)->create();

        $data = [
            'userid'   => 33,
            'cur_page' => '/manage/test.php'
        ];

        $this->put('/api/v1/login-details/' . $loginDetailTestRecord->l_detailid, $data)
            ->seeInDatabase('dental_login_detail', ['userid' => 33])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/login-details/{id} -> LoginDetailsController@destroy method
     * 
     */
    public function testDeleteLoginDetail()
    {
        $loginDetailTestRecord = factory(LoginDetail::class)->create();

        $this->delete('/api/v1/login-details/' . $loginDetailTestRecord->l_detailid)
            ->notSeeInDatabase('dental_login_detail', [
                'l_detailid' => $loginDetailTestRecord->l_detailid
            ])
            ->assertResponseOk();
    }
}
