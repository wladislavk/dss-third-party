<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\AppointmentType;

class AppointmentTypesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/appt-types -> AppointmentTypesController@store method
     * 
     */
    public function testAddAppointmentType()
    {
        $data = [
            'name'      => 'testName',
            'color'     => 'FFFFFF',
            'classname' => 'testClassName',
            'docid'     => 12
        ];

        $this->post('/api/v1/appt-types', $data)
            ->seeInDatabase('dental_appt_types', ['name' => 'testName'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/appt-types/{id} -> AppointmentTypesController@update method
     * 
     */
    public function testUpdateAppointmentType()
    {
        $apptTypeRecord = factory(AppointmentType::class)->create();

        $data = [
            'name'  => 'testUpdatedName',
            'color' => 'FFCCFF'
        ];

        $this->put('/api/v1/appt-types/' . $apptTypeRecord->id, $data)
            ->seeInDatabase('dental_appt_types', ['name' => 'testUpdatedName'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/appt-types/{id} -> AppointmentTypesController@destroy method
     * 
     */
    public function testDeleteAppointmentType()
    {
        $apptTypeRecord = factory(AppointmentType::class)->create();

        $this->delete('/api/v1/appt-types/' . $apptTypeRecord->id)
            ->notSeeInDatabase('dental_appt_types', ['id' => $apptTypeRecord->id])
            ->assertResponseOk();
    }
}
