<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\Uvula;
use Tests\TestCases\ApiTestCase;

class UvulasApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Uvula::class;
    }

    protected function getRoute()
    {
        return '/uvulas';
    }

    protected function getStoreData()
    {
        return [
            "uvula" => "Numquam nulla inventore.",
            "description" => "Voluptatem fugit est quidem provident illo ullam perferendis adipisci.",
            "sortby" => 100,
            "status" => 3,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated uvula description',
            'sortby'      => 7,
        ];
    }
}
