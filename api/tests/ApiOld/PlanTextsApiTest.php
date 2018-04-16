<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\PlanText;
use Tests\TestCases\ApiTestCase;

class PlanTextsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return PlanText::class;
    }

    protected function getRoute()
    {
        return '/plan-texts';
    }

    protected function getStoreData()
    {
        return [
            "plan_text" => "added plan text",
            "status" => 8,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'plan_text' => 'updated plan text',
        ];
    }
}
