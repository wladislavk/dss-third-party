<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\EpworthHomeSleepTest;
use Tests\TestCases\ApiTestCase;

class EpworthHomeSleepTestsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return EpworthHomeSleepTest::class;
    }

    protected function getRoute()
    {
        return '/epworth-home-sleep-tests';
    }

    protected function getStoreData()
    {
        return [
            "hst_id" => 100,
            "epworth_id" => 9,
            "response" => 5,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'epworth_id' => 12,
            'hst_id'     => 7,
        ];
    }
}
