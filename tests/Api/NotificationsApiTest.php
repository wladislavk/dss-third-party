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
}
