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
}
