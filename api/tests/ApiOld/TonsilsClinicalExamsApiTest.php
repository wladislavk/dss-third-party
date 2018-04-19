<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\TonsilsClinicalExam;
use Tests\TestCases\ApiTestCase;

class TonsilsClinicalExamsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return TonsilsClinicalExam::class;
    }

    protected function getRoute()
    {
        return '/tonsils-clinical-exams';
    }

    protected function getStoreData()
    {
        return [
            "formid" => 100,
            "patientid" => 7,
            "mallampati" => "Class IV",
            "tonsils" => "~Obstructive~",
            "tonsils_grade" => "Grade 1",
            "userid" => 0,
            "docid" => 8,
            "status" => 6,
            "adddate" => "2006-06-11 12:38:13",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'docid' => 100,
        ];
    }
}
