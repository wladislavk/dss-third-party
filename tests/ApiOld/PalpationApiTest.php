<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Palpation;
use Tests\TestCases\ApiTestCase;

class PalpationApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Palpation::class;
    }

    protected function getRoute()
    {
        return '/palpation';
    }

    protected function getStoreData()
    {
        return [
            "palpation" => "new palpation",
            "description" => "Blanditiis veniam atque minus voluptas autem.",
            "sortby" => 5,
            "status" => 2,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated palpation',
            'sortby'      => 333,
        ];
    }
}
