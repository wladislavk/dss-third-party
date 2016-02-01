<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\EpworthSleepinessScale;

class EpworthSleepinessScaleApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/epworth-sleepiness-scale -> EpworthSleepinessScaleController@store method
     * 
     */
    public function testAddEpworthSleepinessScale()
    {
        $data = [
            'epworth' => 'test situation',
            'status'  => 7
        ];

        $this->post('/api/v1/epworth-sleepiness-scale', $data)
            ->seeInDatabase('dental_epworth', ['epworth' => 'test situation'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/epworth-sleepiness-scale/{id} -> EpworthSleepinessScaleController@update method
     * 
     */
    public function testUpdateEpworthSleepinessScale()
    {
        $epworthSleepinessScaleTestRecord = factory(EpworthSleepinessScale::class)->create();

        $data = [
            'sortby' => 10,
            'status' => 5
        ];

        $this->put('/api/v1/epworth-sleepiness-scale/' . $epworthSleepinessScaleTestRecord->epworthid, $data)
            ->seeInDatabase('dental_epworth', ['status' => 5])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/epworth-sleepiness-scale/{id} -> EpworthSleepinessScaleController@destroy method
     * 
     */
    public function testDeleteEpworthSleepinessScale()
    {
        $epworthSleepinessScaleTestRecord = factory(EpworthSleepinessScale::class)->create();

        $this->delete('/api/v1/epworth-sleepiness-scale/' . $epworthSleepinessScaleTestRecord->epworthid)
            ->notSeeInDatabase('dental_epworth', [
                'epworthid' => $epworthSleepinessScaleTestRecord->epworthid
            ])
            ->assertResponseOk();
    }
}
