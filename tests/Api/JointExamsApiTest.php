<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Dental\JointExam;
use Tests\TestCases\ApiTestCase;

class JointExamsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return JointExam::class;
    }

    protected function getRoute()
    {
        return '/joint-exams';
    }

    protected function getStoreData()
    {
        return [
            "joint_exam" => "test joint exam",
            "description" => "Consequatur deleniti corrupti voluptatibus.",
            "sortby" => 3,
            "status" => 0,
            "adddate" => "1991-07-03 09:07:19",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated test joint exam',
            'status'      => '7',
        ];
    }
}
