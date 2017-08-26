<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Medicament;
use Tests\TestCases\ApiTestCase;

class MedicationsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Medicament::class;
    }

    protected function getRoute()
    {
        return '/medications';
    }

    protected function getStoreData()
    {
        return [
            "medications" => "eum",
            "description" => "Reprehenderit in exercitationem ullam quia.",
            "sortby" => 4,
            "status" => 7,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated medicament',
            'sortby'      => 123,
        ];
    }
}
