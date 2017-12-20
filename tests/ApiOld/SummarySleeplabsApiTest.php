<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\SummarySleeplab;
use Tests\TestCases\ApiTestCase;

class SummarySleeplabsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return SummarySleeplab::class;
    }

    protected function getRoute()
    {
        return '/summary-sleeplabs';
    }

    protected function getStoreData()
    {
        return [
            "date" => "06/01/1974",
            "sleeptesttype" => "nostrum",
            "place" => "eum",
            "apnea" => "aut",
            "hypopnea" => "soluta",
            "ahi" => "omnis",
            "ahisupine" => "voluptas",
            "rdi" => "officiis",
            "rdisupine" => "deserunt",
            "o2nadir" => "delectus",
            "t9002" => "aut",
            "sleepefficiency" => "qui",
            "cpaplevel" => "eum",
            "dentaldevice" => "5",
            "devicesetting" => "ab",
            "diagnosis" => "eum",
            "notes" => "non",
            "patiendid" => "75",
            "filename" => "test_file.png",
            "testnumber" => "114058519",
            "needed" => "No",
            "scheddate" => "08/09/2011",
            "completed" => "No",
            "interpolation" => "No",
            "copyreqdate" => "11/29/2010",
            "sleeplab" => "43",
            "diagnosising_doc" => "Alias delectus laborum.",
            "diagnosising_npi" => "2815240795",
            "image_id" => "33",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'filename' => 'updated_test_file.bmp',
        ];
    }
}
