<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class CalendarApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    protected $id;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/calendar -> Api/ApiCalendarController@store method
     * 
     */
    public function testAddCalendar()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

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

        $this->post('/api/v1/calendar', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_calendar', ['category' => 'testCategory']);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/calendar/{id} -> Api/ApiCalendarController@update method
     * 
     */
    public function testUpdateCalendar()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $calendarTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\Calendar::class)->create();

        $data = [
            'description' => 'updated test description',
            'category'    => 'updatedTestCategory',
            'patientid'   => 100
        ];

        $this->put('/api/v1/calendar/' . $calendarTestRecord->id, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_calendar', ['category' => 'updatedTestCategory']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/calendar/{id} -> Api/ApiCalendarController@destroy method
     * 
     */
    public function testDeleteCalendar()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $calendarTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\Calendar::class)->create();

        $this->delete('/api/v1/calendar/' . $calendarTestRecord->id)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('dental_calendar', ['id' => $calendarTestRecord->id]);
    }
}
