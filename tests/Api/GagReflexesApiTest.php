<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\GagReflex;
use Tests\TestCases\ApiTestCase;

class GagReflexesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return GagReflex::class;
    }

    protected function getRoute()
    {
        return '/gag-reflexes';
    }

    protected function getStoreData()
    {
        return [
            "gag_reflex" => "est",
            "description" => "Aut aut dolorem illum esse ullam.",
            "sortby" => 100,
            "status" => 4,
            "adddate" => "1980-03-09 00:36:01",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated gag reflex',
            'status'      => 1,
        ];
    }
}
