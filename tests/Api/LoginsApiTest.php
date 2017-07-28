<?php
namespace Tests\Api;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\Login;
use Tests\TestCases\ApiTestCase;

class LoginsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Login::class;
    }

    protected function getRoute()
    {
        return '/logins';
    }

    protected function getStoreData()
    {
        return [
            "docid" => 100,
            "userid" => 9,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'userid' => 33,
        ];
    }

    public function testLogout()
    {
        $this->post(self::ROUTE_PREFIX . '/logout');
        $this->assertResponseOk();
    }
}
