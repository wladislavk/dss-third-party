<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\HomeSleepTest;

class HomeSleepTestsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/home-sleep-tests -> HomeSleepTestsController@store method
     * 
     */
    public function testAddHomeSleepTest()
    {
        $data = factory(HomeSleepTest::class)->make()->toArray();

        $data['user_id'] = 100;

        $this->post('/api/v1/home-sleep-tests', $data)
            ->seeInDatabase('dental_hst', ['user_id' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/home-sleep-tests/{id} -> HomeSleepTestsController@update method
     * 
     */
    public function testUpdateHomeSleepTest()
    {
        $homeSleepTestRecord = factory(HomeSleepTest::class)->create();

        $data = [
            'office_notes' => 'updated Home Sleep Tests',
            'user_id'      => 7
        ];

        $this->put('/api/v1/home-sleep-tests/' . $homeSleepTestRecord->id, $data)
            ->seeInDatabase('dental_hst', [
                'office_notes' => 'updated Home Sleep Tests'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/home-sleep-tests/{id} -> HomeSleepTestsController@destroy method
     * 
     */
    public function testDeleteHomeSleepTest()
    {
        $homeSleepTestRecord = factory(HomeSleepTest::class)->create();

        $this->delete('/api/v1/home-sleep-tests/' . $homeSleepTestRecord->id)
            ->notSeeInDatabase('dental_hst', [
                'id' => $homeSleepTestRecord->id
            ])
            ->assertResponseOk();
    }
}
