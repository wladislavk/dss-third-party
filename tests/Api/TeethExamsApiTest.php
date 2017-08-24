<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\TeethExam;
use Tests\TestCases\ApiTestCase;

class TeethExamsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return TeethExam::class;
    }

    protected function getRoute()
    {
        return '/teeth-exams';
    }

    protected function getStoreData()
    {
        return [
            "exam_teeth" => "ad",
            "description" => "Explicabo iste deserunt eius aliquid.",
            "sortby" => 7,
            "status" => 5,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated description',
            'status'      => 7,
        ];
    }
}
