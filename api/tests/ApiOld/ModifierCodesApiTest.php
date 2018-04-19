<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\ModifierCode;
use Tests\TestCases\ApiTestCase;

class ModifierCodesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return ModifierCode::class;
    }

    protected function getRoute()
    {
        return '/modifier-codes';
    }

    protected function getStoreData()
    {
        return [
            "modifier_code" => "69",
            "description" => "Nemo similique velit excepturi voluptates.",
            "sortby" => 6,
            "status" => 8,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated description',
            'status'      => 7,
        ];
    }
}
