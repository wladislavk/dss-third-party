<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Notification;
use Tests\TestCases\ApiTestCase;

class NotificationsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Notification::class;
    }

    protected function getRoute()
    {
        return '/notifications';
    }

    protected function getStoreData()
    {
        return [
            "patientid" => 100,
            "docid" => 9,
            "notification" => "Cum eaque omnis illum aspernatur.",
            "notification_type" => "sit",
            "status" => 9,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'docid'        => 100,
            'notification' => 'updated notification',
        ];
    }

    public function testGetWithFilter()
    {
        factory($this->getModel(), 4)->create(['patientid' => 1]);
        factory($this->getModel(), 4)->create(['patientid' => 2]);
        $filter = [
            'where' => [
                'patientid' => 2,
            ],
        ];
        $this->post(self::ROUTE_PREFIX . '/notifications/with-filter', $filter);
        $this->assertResponseOk();
        $this->assertEquals(4, count($this->getResponseData()));
        $this->assertEquals(2, $this->getResponseData()[0]['patientid']);
    }
}
