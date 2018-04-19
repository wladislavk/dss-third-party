<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth;
use Tests\TestCases\ApiTestCase;

class MissingTeethApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return MissingTooth::class;
    }

    protected function getRoute()
    {
        return '/missing-teeth';
    }

    protected function getStoreData()
    {
        return [
            "formid" => 4,
            "patientid" => 4,
            "pck" => "~7830967~9352952",
            "rec" => "~491~707~754",
            "mob" => "~8090864~3694264~9804310",
            "rec1" => "~~~~~",
            "pck1" => "~2~1",
            "s1" => "7",
            "s2" => "4",
            "s3" => "6",
            "s4" => "0",
            "s5" => "0",
            "s6" => "5",
            "userid" => 100,
            "docid" => 0,
            "status" => 5,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'pck'    => '~17~',
            'userid' => 7,
        ];
    }
}
