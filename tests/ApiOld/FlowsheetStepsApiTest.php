<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\FlowsheetStep;
use Tests\TestCases\ApiTestCase;

class FlowsheetStepsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return FlowsheetStep::class;
    }

    protected function getRoute()
    {
        return '/flowsheet-steps';
    }

    protected function getStoreData()
    {
        return [
            "name" => "excepturi",
            "sort_by" => 1,
            "section" => 100,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'name'    => 'updated flowsheet step',
            'section' => 123,
        ];
    }
}
