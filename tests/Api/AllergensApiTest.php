<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Dental\Allergen;
use Tests\TestCases\ApiTestCase;

class AllergensApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Allergen::class;
    }

    protected function getRoute()
    {
        return '/allergens';
    }

    protected function getStoreData()
    {
        $newAllergen = 'new' . date('Y-m-d H:i:s');
        return [
            'allergens'   => $newAllergen,
            'description' => 'This is test description',
            'sortby'      => 12,
            'status'      => 2,
        ];
    }

    protected function getUpdateData()
    {
        $updatedAllergen = 'updated' . date('Y-m-d H:i:s');
        return [
            'allergens'   => $updatedAllergen,
            'status'      => 5,
        ];
    }
}
