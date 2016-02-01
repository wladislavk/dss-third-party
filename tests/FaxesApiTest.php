<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

use DentalSleepSolutions\Eloquent\Dental\Fax;

class FaxesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/faxes -> FaxesController@store method
     * 
     */
    public function testAddFax()
    {
        $data = factory(Fax::class)->make()->toArray();

        $data['patientid'] = 10;

        $this->post('/api/v1/faxes', $data)
            ->seeInDatabase('dental_faxes', ['patientid' => 10])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/faxes/{id} -> FaxesController@update method
     * 
     */
    public function testUpdateFax()
    {
        $faxTestRecord = factory(Fax::class)->create();

        $data = ['userid' => 100];

        $this->put('/api/v1/faxes/' . $faxTestRecord->id, $data)
            ->seeInDatabase('dental_faxes', ['userid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/faxes/{id} -> FaxesController@destroy method
     * 
     */
    public function testDeleteFax()
    {
        $faxTestRecord = factory(Fax::class)->create();

        $this->delete('/api/v1/faxes/' . $faxTestRecord->id)
            ->notSeeInDatabase('dental_faxes', ['id' => $faxTestRecord->id])
            ->assertResponseOk();
    }
}
