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

    public function testGetActive()
    {
        $this->post(self::ROUTE_PREFIX . '/qualifiers/active');
        $this->assertResponseOk();
        $this->assertEquals(8, count($this->getResponseData()));
        $expectedFirst = [
            'qualifierid' => 1,
            'qualifier' => '0B State license number',
            'description' => '',
            'sortby' => 1,
            'status' => 1,
        ];
        $first = $this->getResponseData()[0];
        unset($first['adddate']);
        unset($first['ip_address']);
        $this->assertEquals($expectedFirst, $first);
    }
}
