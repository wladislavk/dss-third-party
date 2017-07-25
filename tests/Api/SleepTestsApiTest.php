<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Dental\SleepTest;
use Tests\TestCases\ApiTestCase;

class SleepTestsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return SleepTest::class;
    }

    protected function getRoute()
    {
        return '/sleep-tests';
    }

    protected function getStoreData()
    {
        return [
            "formid" => 1,
            "patientid" => 100,
            "epworthid" => "1|3~2|2~3|2~4|3~5|3~6|3~7|3~8|2~",
            "analysis" => "Accusantium autem exercitationem ex delectus architecto et.",
            "userid" => 1,
            "docid" => 8,
            "status" => 5,
            "adddate" => "1981-12-31 21:29:49",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'formid'   => 100,
            'analysis' => 'updated sleep test',
        ];
    }
}
