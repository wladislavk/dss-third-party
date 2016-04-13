<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\QPage2Surgery;

class QPage2SurgeriesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/q-page2-surgeries -> QPage2SurgeriesController@store method
     * 
     */
    public function testAddQPage2Surgery()
    {
        $data = factory(QPage2Surgery::class)->make()->toArray();

        $data['patientid'] = 100;

        $this->post('/api/v1/q-page2-surgeries', $data)
            ->seeInDatabase('dental_q_page2_surgery', ['patientid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/q-page2-surgeries/{id} -> QPage2SurgeriesController@update method
     * 
     */
    public function testUpdateQPage2Surgery()
    {
        $qPage2SurgeryTestRecord = factory(QPage2Surgery::class)->create();

        $data = [
            'patientid' => 200,
            'surgeon'   => 'John Doe'
        ];

        $this->put('/api/v1/q-page2-surgeries/' . $qPage2SurgeryTestRecord->id, $data)
            ->seeInDatabase('dental_q_page2_surgery', ['patientid' => 200])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/q-page2-surgeries/{id} -> QPage2SurgeriesController@destroy method
     * 
     */
    public function testDeleteQPage2Surgery()
    {
        $qPage2SurgeryTestRecord = factory(QPage2Surgery::class)->create();

        $this->delete('/api/v1/q-page2-surgeries/' . $qPage2SurgeryTestRecord->id)
            ->notSeeInDatabase('dental_q_page2_surgery', [
                'id' => $qPage2SurgeryTestRecord->id
            ])
            ->assertResponseOk();
    }
}
