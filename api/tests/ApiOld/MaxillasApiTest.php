<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\Maxilla;
use Tests\TestCases\ApiTestCase;

class MaxillasApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Maxilla::class;
    }

    protected function getRoute()
    {
        return '/maxillas';
    }

    protected function getStoreData()
    {
        return [
            "maxilla" => "dolorem",
            "description" => "Voluptas nihil voluptatem neque quis.",
            "sortby" => 3,
            "status" => 7,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated maxilla',
            'sortby'      => 123,
        ];
    }
}
