<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

use DentalSleepSolutions\Eloquent\Dental\Calendar;

class CalendarsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/calendars -> CalendarsController@store method
     * 
     */
    public function testAddCalendar()
    {
        $data = [
            'start_date'   => Carbon::now()->addDays(1),
            'end_date'     => Carbon::now()->addDays(2),
            'description'  => 'test description',
            'event_id'     => 1123456789123,
            'docid'        => 2,
            'category'     => 'testCategory',
            'producer_id'  => 2,
            'patientid'    => 2,
            'rec_type'     => 'test',
            'event_length' => 1234,
            'event_pid'    => 1234,
            'res_id'       => 2,
            'rec_pattern'  => 'test'
        ];

        $this->post('/api/v1/calendars', $data)
            ->seeInDatabase('dental_calendar', ['category' => 'testCategory'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/calendars/{id} -> CalendarsController@update method
     * 
     */
    public function testUpdateCalendar()
    {
        $calendarTestRecord = factory(Calendar::class)->create();

        $data = [
            'description' => 'updated test description',
            'category'    => 'updatedTestCategory',
            'patientid'   => 100
        ];

        $this->put('/api/v1/calendars/' . $calendarTestRecord->id, $data)
            ->seeInDatabase('dental_calendar', ['category' => 'updatedTestCategory'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/calendars/{id} -> CalendarsController@destroy method
     * 
     */
    public function testDeleteCalendar()
    {
        $calendarTestRecord = factory(Calendar::class)->create();

        $this->delete('/api/v1/calendars/' . $calendarTestRecord->id)
            ->notSeeInDatabase('dental_calendar', ['id' => $calendarTestRecord->id])
            ->assertResponseOk();
    }
}
