<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\FlowsheetNextStep;
use Tests\TestCases\ApiTestCase;

class FlowsheetNextStepsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return FlowsheetNextStep::class;
    }

    protected function getRoute()
    {
        return '/flowsheet-next-steps';
    }

    protected function getStoreData()
    {
        return [
            "parent_id" => 100,
            "child_id" => 9,
            "sort_by" => 2,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'child_id' => 100,
        ];
    }
}
