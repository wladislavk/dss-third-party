<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\QPage2Surgery;
use Tests\TestCases\ApiTestCase;

class QPage2SurgeriesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return QPage2Surgery::class;
    }

    protected function getRoute()
    {
        return '/q-page2-surgeries';
    }

    protected function getStoreData()
    {
        return [
            "patientid" => 100,
            "surgery_date" => "2015-02-12",
            "surgery" => "Ea consequatur vero minima et error minus non.",
            "surgeon" => "Prof. Mitchel Herman",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'patientid' => 200,
            'surgeon'   => 'John Doe',
        ];
    }
}
