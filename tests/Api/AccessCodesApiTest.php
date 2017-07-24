<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Dental\AccessCode;
use Tests\TestCases\ApiTestCase;

class AccessCodesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return AccessCode::class;
    }

    protected function getRoute()
    {
        return '/access-codes';
    }

    protected function getStoreData()
    {
        $newCode = 'new' . date('Y-m-d H:i:s');
        return [
            'access_code' => $newCode,
            'notes'       => 'additional test notes',
            'status'      => 1,
            'plan_id'     => 3,
        ];
    }

    protected function getUpdateData()
    {
        $newCode = 'update' . date('Y-m-d H:i:s');
        return [
            'access_code' => $newCode,
            'status' => 2,
        ];
    }
}
