<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\ScreenerEpworth;
use Tests\TestCases\ApiTestCase;

class ScreenerEpworthApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return ScreenerEpworth::class;
    }

    protected function getRoute()
    {
        return '/screener-epworth';
    }

    protected function getStoreData()
    {
        return [
            "screener_id" => 100,
            "epworth_id" => 2,
            "response" => 2,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'epworth_id' => 100,
        ];
    }
}
