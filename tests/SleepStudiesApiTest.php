<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\SleepStudy;

class SleepStudiesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/sleep-studies -> SleepStudiesController@store method
     * 
     */
    public function testAddSleepStudy()
    {
        $data = factory(SleepStudy::class)->make()->toArray();

        $data['docid'] = '100';

        $this->post('/api/v1/sleep-studies', $data)
            ->seeInDatabase('dental_sleepstudy', ['docid' => '100'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/sleep-studies/{id} -> SleepStudiesController@update method
     * 
     */
    public function testUpdateSleepStudy()
    {
        $sleepStudyTestRecord = factory(SleepStudy::class)->create();

        $data = [
            'patientid'  => '253',
            'testnumber' => '123456789'
        ];

        $this->put('/api/v1/sleep-studies/' . $sleepStudyTestRecord->id, $data)
            ->seeInDatabase('dental_sleepstudy', ['patientid' => '253'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/sleep-studies/{id} -> SleepStudiesController@destroy method
     * 
     */
    public function testDeleteSleepStudy()
    {
        $sleepStudyTestRecord = factory(SleepStudy::class)->create();

        $this->delete('/api/v1/sleep-studies/' . $sleepStudyTestRecord->id)
            ->notSeeInDatabase('dental_sleepstudy', [
                'id' => $sleepStudyTestRecord->id
            ])
            ->assertResponseOk();
    }
}
