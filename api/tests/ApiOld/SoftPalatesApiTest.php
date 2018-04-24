<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\SoftPalate;
use Tests\TestCases\ApiTestCase;

class SoftPalatesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return SoftPalate::class;
    }

    protected function getRoute()
    {
        return '/soft-palates';
    }

    protected function getStoreData()
    {
        return [
            "soft_palate" => "Corporis inventore rerum sed iure.",
            "description" => "Soluta repellat maxime dolorem et voluptatem blanditiis vel velit molestiae.",
            "sortby" => 100,
            "status" => 8,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated soft palate',
            'status'      => 8,
        ];
    }
}
