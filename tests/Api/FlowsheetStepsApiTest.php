<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\User as BaseUser;
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

    public function testGetBySection()
    {
        $this->get(self::ROUTE_PREFIX . '/flowsheet-steps/by-section');
        $this->assertResponseOk();
        $expected = [
            'first' => [
                [
                    'id' => 1,
                    'name' => 'Initial Contact',
                    'sort_by' => 1,
                    'section' => 1,
                    'adddate' => '2012-10-15 18:47:56',
                    'ip_address' => null,
                    'rank' => 1,
                ],
                [
                    'id' => 15,
                    'name' => 'Baseline Sleep Test',
                    'sort_by' => 2,
                    'section' => 1,
                    'adddate' => '2012-10-15 18:47:56',
                    'ip_address' => null,
                    'rank' => 2,
                ],
                [
                    'id' => 2,
                    'name' => 'Consult',
                    'sort_by' => 3,
                    'section' => 1,
                    'adddate' => '2012-10-15 18:47:56',
                    'ip_address' => null,
                    'rank' => 3,
                ],
                [
                    'id' => 4,
                    'name' => 'Impressions',
                    'sort_by' => 4,
                    'section' => 1,
                    'adddate' => '2012-10-15 18:47:56',
                    'ip_address' => null,
                    'rank' => 4,
                ],
                [
                    'id' => 7,
                    'name' => 'Device Delivery',
                    'sort_by' => 5,
                    'section' => 1,
                    'adddate' => '2012-10-15 18:47:56',
                    'ip_address' => null,
                    'rank' => 5,
                ],
                [
                    'id' => 8,
                    'name' => 'Check/Follow Up',
                    'sort_by' => 6,
                    'section' => 1,
                    'adddate' => '2012-10-15 18:47:56',
                    'ip_address' => null,
                    'rank' => 6,
                ],
                [
                    'id' => 3,
                    'name' => 'Titration Sleep Study',
                    'sort_by' => 8,
                    'section' => 1,
                    'adddate' => '2012-10-15 18:47:56',
                    'ip_address' => null,
                    'rank' => 7,
                ],
                [
                    'id' => 11,
                    'name' => 'Treatment Complete',
                    'sort_by' => 9,
                    'section' => 1,
                    'adddate' => '2012-10-15 18:47:56',
                    'ip_address' => null,
                    'rank' => 8,
                ],
                [
                    'id' => 12,
                    'name' => 'Annual Recall',
                    'sort_by' => 10,
                    'section' => 1,
                    'adddate' => '2012-10-15 18:47:56',
                    'ip_address' => null,
                    'rank' => 9,
                ],
            ],
            'second' => [
                [
                    'id' => 14,
                    'name' => 'Not a Candidate',
                    'sort_by' => 1,
                    'section' => 2,
                    'adddate' => '2012-10-15 18:47:56',
                    'ip_address' => null,
                    'rank' => 1,
                ],
                [
                    'id' => 5,
                    'name' => 'Delaying Tx/Waiting',
                    'sort_by' => 2,
                    'section' => 2,
                    'adddate' => '2012-10-15 18:47:56',
                    'ip_address' => null,
                    'rank' => 2,
                ],
                [
                    'id' => 9,
                    'name' => 'Pt. Non-compliant',
                    'sort_by' => 3,
                    'section' => 2,
                    'adddate' => '2012-10-15 18:47:56',
                    'ip_address' => null,
                    'rank' => 3,
                ],
                [
                    'id' => 6,
                    'name' => 'Refused Treatment',
                    'sort_by' => 4,
                    'section' => 2,
                    'adddate' => '2012-10-15 18:47:56',
                    'ip_address' => null,
                    'rank' => 4,
                ],
                [
                    'id' => 13,
                    'name' => 'Termination',
                    'sort_by' => 5,
                    'section' => 2,
                    'adddate' => '2012-10-15 18:47:56',
                    'ip_address' => null,
                    'rank' => 5,
                ],
            ],
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }
}
