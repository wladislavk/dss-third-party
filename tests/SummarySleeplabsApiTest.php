<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\SummarySleeplab;

class SummarySleeplabsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/summary-sleeplabs -> SummarySleeplabsController@store method
     * 
     */
    public function testAddSummarySleeplab()
    {
        $data = factory(SummarySleeplab::class)->make()->toArray();

        $data['filename'] = 'test_file.png';

        $this->post('/api/v1/summary-sleeplabs', $data)
            ->seeInDatabase('dental_summ_sleeplab', ['filename' => 'test_file.png'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/summary-sleeplabs/{id} -> SummarySleeplabsController@update method
     * 
     */
    public function testUpdateSummarySleeplab()
    {
        $summarySleeplabTestRecord = factory(SummarySleeplab::class)->create();

        $data = ['filename' => 'updated_test_file.bmp'];

        $this->put('/api/v1/summary-sleeplabs/' . $summarySleeplabTestRecord->id, $data)
            ->seeInDatabase('dental_summ_sleeplab', ['filename' => 'updated_test_file.bmp'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/summary-sleeplabs/{id} -> SummarySleeplabsController@destroy method
     * 
     */
    public function testDeleteSummarySleeplab()
    {
        $summarySleeplabTestRecord = factory(SummarySleeplab::class)->create();

        $this->delete('/api/v1/summary-sleeplabs/' . $summarySleeplabTestRecord->id)
            ->notSeeInDatabase('dental_summ_sleeplab', [
                'id' => $summarySleeplabTestRecord->id
            ])
            ->assertResponseOk();
    }
}
