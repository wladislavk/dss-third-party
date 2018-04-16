<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\PlaceService;
use Tests\TestCases\ApiTestCase;

class PlaceServicesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return PlaceService::class;
    }

    protected function getRoute()
    {
        return '/place-services';
    }

    protected function getStoreData()
    {
        return [
            "place_service" => "123",
            "description" => "Labore quos sint quasi ut minima dolorum.",
            "sortby" => 5,
            "status" => 0,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated place service',
            'status'      => 5,
        ];
    }
}
