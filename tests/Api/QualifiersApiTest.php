<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Qualifier;
use Tests\TestCases\ApiTestCase;

class QualifiersApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Qualifier::class;
    }

    protected function getRoute()
    {
        return '/qualifiers';
    }

    protected function getStoreData()
    {
        return [
            "qualifier" => "Ducimus voluptatem nulla quia accusantium maiores eaque.",
            "description" => "Labore labore non hic dolorem.",
            "sortby" => 234,
            "status" => 2,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated qualifier',
            'status'      => 5,
        ];
    }
}
