<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\MemoAdmin;
use Tests\TestCases\ApiTestCase;

class AdminMemoApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return MemoAdmin::class;
    }

    protected function getRoute()
    {
        return '/memo';
    }

    protected function getStoreData()
    {
        $date = date("Y-m-d");
        return [
            'memo' => 'PHPUnit Inserted Test Memo',
            'last_update' => $date,
            'off_date' => date('Y-m-d', strtotime("$date +7 days")),
        ];
    }

    protected function getUpdateData()
    {
        $date = date("Y-m-d");
        return [
            'memo' => 'PHPUnit Updated Test Memo',
            'last_update' => $date,
            'off_date' => date('Y-m-d', strtotime("$date +7 days")),
        ];
    }

    public function testShow()
    {
        $this->markTestSkipped('API method is incomplete');
    }

    public function testGetCurrent()
    {
        $this->post(self::ROUTE_PREFIX . '/memos/current');
        $this->assertResponseOk();
        $expected = [
            [
                'memo_id' => 2,
                'memo' => ' Testing Again',
                'last_update' => '2010-10-19',
                'off_date' => '2010-10-20',
            ],
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }
}
