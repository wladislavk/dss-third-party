<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class AppointmentTypeApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    protected $id;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/appt-type -> Api/ApiAppointmentTypeController@store method
     * 
     */
    public function testAddAppointmentType()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $data = [
            'name'      => 'testName',
            'color'     => 'FFFFFF',
            'classname' => 'testClassName',
            'docid'     => 12
        ];

        $this->post('/api/v1/appt-type', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_appt_types', ['name' => 'testName']);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/appt-type/{id} -> Api/ApiAppointmentTypeController@update method
     * 
     */
    public function testUpdateAppointmentType()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $apptTypeRecord = factory(DentalSleepSolutions\Eloquent\Dental\AppointmentType::class)->create();

        $data = [
            'name'  => 'testUpdatedName',
            'color' => 'FFCCFF'
        ];

        $this->put('/api/v1/appt-type/' . $apptTypeRecord->id, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_appt_types', ['name' => 'testUpdatedName']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/appt-type/{id} -> Api/ApiAppointmentTypeController@destroy method
     * 
     */
    public function testDeleteAppointmentType()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $apptTypeRecord = factory(DentalSleepSolutions\Eloquent\Dental\AppointmentType::class)->create();

        $this->delete('/api/v1/appt-type/' . $apptTypeRecord->id)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('dental_appt_types', ['id' => $apptTypeRecord->id]);
    }
}
