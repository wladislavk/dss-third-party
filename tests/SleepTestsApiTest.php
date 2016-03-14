<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\SleepTest;

class SleepTestsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/sleep-tests -> SleepTestsController@store method
     * 
     */
    public function testAddSleepTest()
    {
        $data = factory(SleepTest::class)->make()->toArray();

        $data['patientid'] = 100;

        $this->post('/api/v1/sleep-tests', $data)
            ->seeInDatabase('dental_q_sleep', ['patientid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/sleep-tests/{id} -> SleepTestsController@update method
     * 
     */
    public function testUpdateSleepTest()
    {
        $insuranceTestRecord = factory(SleepTest::class)->create();

        $data = [
            'formid'   => 100,
            'analysis' => 'updated sleep test'
        ];

        $this->put('/api/v1/sleep-tests/' . $insuranceTestRecord->q_sleepid, $data)
            ->seeInDatabase('dental_q_sleep', ['formid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/sleep-tests/{id} -> SleepTestsController@destroy method
     * 
     */
    public function testDeleteSleepTest()
    {
        $insuranceTestRecord = factory(SleepTest::class)->create();

        $this->delete('/api/v1/sleep-tests/' . $insuranceTestRecord->q_sleepid)
            ->notSeeInDatabase('dental_q_sleep', [
                'q_sleepid' => $insuranceTestRecord->q_sleepid
            ])
            ->assertResponseOk();
    }
}
