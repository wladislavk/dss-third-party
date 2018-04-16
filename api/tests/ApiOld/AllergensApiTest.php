<?php
namespace Tests\ApiOld;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use DentalSleepSolutions\Eloquent\Models\Dental\Allergen;
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
