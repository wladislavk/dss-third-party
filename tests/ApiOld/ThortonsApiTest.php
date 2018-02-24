<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Thorton;
use Tests\TestCases\ApiTestCase;

class ThortonsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Thorton::class;
    }

    protected function getRoute()
    {
        return '/thortons';
    }

    protected function getStoreData()
    {
        return [
            "formid" => 100,
            "patientid" => 1,
            "snore_1" => 3,
            "snore_2" => 9,
            "snore_3" => 0,
            "snore_4" => 9,
            "snore_5" => 8,
            "tot_score" => 5,
            "userid" => 2,
            "docid" => 3,
            "status" => 4,
        ];
    }

    protected function getUpdateData()
    {
        $data = [
            'patientid' => 200,
            'tot_score' => 1234,
        ];
        return $data;
    }
}
