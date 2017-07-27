<?php
namespace Tests\Api;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\Calendar;
use Tests\TestCases\ApiTestCase;

class CalendarsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Calendar::class;
    }

    protected function getRoute()
    {
        return '/calendars';
    }

    protected function getStoreData()
    {
        return [
            'start_date'   => Carbon::now()->addDays(1)->format('Y-m-d H:i:s'),
            'end_date'     => Carbon::now()->addDays(2)->format('Y-m-d H:i:s'),
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
            'rec_pattern'  => 'test',
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated test description',
            'category'    => 'updatedTestCategory',
            'patientid'   => 100,
        ];
    }
}
