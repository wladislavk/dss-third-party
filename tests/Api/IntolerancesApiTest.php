<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Dental\Intolerance;
use Tests\TestCases\ApiTestCase;

class IntolerancesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Intolerance::class;
    }

    protected function getRoute()
    {
        return '/intolerances';
    }

    protected function getStoreData()
    {
        return [
            "intolerance" => "Necessitatibus cumque ut nemo minima excepturi.",
            "description" => "Test intolerance description",
            "sortby" => 8,
            "status" => 0,
            "adddate" => "2009-10-24 19:44:55",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated intolerance description',
            'status'      => 8,
        ];
    }
}
