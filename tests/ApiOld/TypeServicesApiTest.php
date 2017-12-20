<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\TypeService;
use Tests\TestCases\ApiTestCase;

class TypeServicesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return TypeService::class;
    }

    protected function getRoute()
    {
        return '/type-services';
    }

    protected function getStoreData()
    {
        return [
            "type_service" => "45",
            "description" => "Et repellendus voluptas voluptates laborum eveniet doloremque.",
            "sortby" => 100,
            "status" => 7,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated description',
            'sortby'      => 7,
            'status'      => 8,
        ];
    }
}
