<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\SleepStudy;
use Tests\TestCases\ApiTestCase;

class SleepStudiesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return SleepStudy::class;
    }

    protected function getRoute()
    {
        return '/sleep-studies';
    }

    protected function getStoreData()
    {
        return [
            "testnumber" => "605788657",
            "docid" => "100",
            "patientid" => "96",
            "needed" => "Yes",
            "sleeplabwheresched" => "40",
            "completed" => "Yes",
            "interpolation" => "Yes",
            "labtype" => "PSG",
            "sleeplab" => "66",
            "scanext" => "pdf",
            "date" => "02726208",
            "filename" => "mc34ncvs32dh6n4",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'patientid'  => '253',
            'testnumber' => '123456789',
        ];
    }
}
