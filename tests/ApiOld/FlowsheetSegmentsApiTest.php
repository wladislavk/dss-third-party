<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\FlowsheetSegment;
use Tests\TestCases\ApiTestCase;

class FlowsheetSegmentsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return FlowsheetSegment::class;
    }

    protected function getRoute()
    {
        return '/flowsheet-segments';
    }

    protected function getStoreData()
    {
        return [
            "section" => "aut",
            "content" => "Sunt minima iure repellat voluptatem.",
            "sortby" => 100,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'section' => 'updated section',
            'sortby'  => 7,
        ];
    }
}
