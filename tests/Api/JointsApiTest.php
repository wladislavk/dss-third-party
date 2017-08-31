<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Joint;
use Tests\TestCases\ApiTestCase;

class JointsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Joint::class;
    }

    protected function getRoute()
    {
        return '/joints';
    }

    protected function getStoreData()
    {
        return [
            "joint" => "test add joint",
            "description" => "Consequatur doloremque cupiditate.",
            "sortby" => 3,
            "status" => 4,
            "adddate" => "1985-12-31 22:20:58",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'joint'  => 'test updated joint',
            'status' => 8,
        ];
    }
}
