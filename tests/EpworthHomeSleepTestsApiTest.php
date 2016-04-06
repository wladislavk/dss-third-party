<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\EpworthHomeSleepTest;

class EpworthHomeSleepTestsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/epworth-home-sleep-tests -> EpworthHomeSleepTestsController@store method
     * 
     */
    public function testAddEpworthHomeSleepTest()
    {
        $data = factory(EpworthHomeSleepTest::class)->make()->toArray();

        $data['hst_id'] = 100;

        $this->post('/api/v1/epworth-home-sleep-tests', $data)
            ->seeInDatabase('dental_hst_epworth', ['hst_id' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/epworth-home-sleep-tests/{id} -> EpworthHomeSleepTestsController@update method
     * 
     */
    public function testUpdateEpworthHomeSleepTest()
    {
        $epworthHomeSleepTestRecord = factory(EpworthHomeSleepTest::class)->create();

        $data = [
            'epworth_id' => 12,
            'hst_id'     => 7
        ];

        $this->put('/api/v1/epworth-home-sleep-tests/' . $epworthHomeSleepTestRecord->id, $data)
            ->seeInDatabase('dental_hst_epworth', [
                'epworth_id' => 12
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/epworth-home-sleep-tests/{id} -> EpworthHomeSleepTestsController@destroy method
     * 
     */
    public function testDeleteEpworthHomeSleepTest()
    {
        $epworthHomeSleepTestRecord = factory(EpworthHomeSleepTest::class)->create();

        $this->delete('/api/v1/epworth-home-sleep-tests/' . $epworthHomeSleepTestRecord->id)
            ->notSeeInDatabase('dental_hst_epworth', [
                'id' => $epworthHomeSleepTestRecord->id
            ])
            ->assertResponseOk();
    }
}
