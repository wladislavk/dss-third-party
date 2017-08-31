<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\DocumentCategory;
use Tests\TestCases\ApiTestCase;

class DocumentCategoriesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return DocumentCategory::class;
    }

    protected function getRoute()
    {
        return '/document-categories';
    }

    protected function getStoreData()
    {
        return [
            'name'   => 'John Doe',
            'status' => 5,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'status' => 7,
        ];
    }

    public function testActive()
    {
        $this->post(self::ROUTE_PREFIX . '/document-categories/active');
        $this->assertResponseOk();
        $expected = [
            [
                'categoryid' => 23,
                'name' => 'Final test',
                'status' => 1,
                'adddate' => '2011-06-23 15:50:25',
                'ip_address' => '192.168.1.168',
            ],
            [
                'categoryid' => 20,
                'name' => 'test 2',
                'status' => 1,
                'adddate' => null,
                'ip_address' => null,
            ],
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }
}
