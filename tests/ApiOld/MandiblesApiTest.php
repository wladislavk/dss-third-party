<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Mandible;
use Tests\TestCases\ApiTestCase;

class MandiblesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Mandible::class;
    }

    protected function getRoute()
    {
        return '/mandibles';
    }

    protected function getStoreData()
    {
        return [
            "mandible" => "non",
            "description" => "Animi ipsa labore architecto cupiditate.",
            "sortby" => 9,
            "status" => 7,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated mandible',
            'sortby'      => 123,
        ];
    }
}
