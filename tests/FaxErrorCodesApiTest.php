<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\FaxErrorCode;

class FaxErrorCodesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/fax-error-codes -> FaxErrorCodesController@store method
     * 
     */
    public function testAddFaxErrorCode()
    {
        $data = factory(FaxErrorCode::class)->make()->toArray();

        $data['error_code'] = '22222';

        $this->post('/api/v1/fax-error-codes', $data)
            ->seeInDatabase('dental_fax_error_codes', ['error_code' => '22222'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/fax-error-codes/{id} -> FaxErrorCodesController@update method
     * 
     */
    public function testUpdateFaxErrorCode()
    {
        $faxErrorCodeTestRecord = factory(FaxErrorCode::class)->create();

        $data = ['error_code' => '11111'];

        $this->put('/api/v1/fax-error-codes/' . $faxErrorCodeTestRecord->id, $data)
            ->seeInDatabase('dental_fax_error_codes', ['error_code' => '11111'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/fax-error-codes/{id} -> FaxErrorCodesController@destroy method
     * 
     */
    public function testDeleteFaxErrorCode()
    {
        $faxErrorCodeTestRecord = factory(FaxErrorCode::class)->create();

        $this->delete('/api/v1/fax-error-codes/' . $faxErrorCodeTestRecord->id)
            ->notSeeInDatabase('dental_fax_error_codes', [
                'id' => $faxErrorCodeTestRecord->id
            ])
            ->assertResponseOk();
    }
}
