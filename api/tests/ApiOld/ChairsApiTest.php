<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\Chair;
use Tests\TestCases\ApiTestCase;

class ChairsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Chair::class;
    }

    protected function getRoute()
    {
        return '/chairs';
    }

    protected function getStoreData()
    {
        return [
            'name' => 'my_chair',
            'rank' => 7,
            'docid' => 100,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'name' => 'updated chair',
        ];
    }
}
