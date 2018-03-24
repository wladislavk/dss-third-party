<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\SupportCategory;
use Tests\TestCases\ApiTestCase;

class SupportCategoriesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return SupportCategory::class;
    }

    protected function getRoute()
    {
        return '/support-categories';
    }

    protected function getStoreData()
    {
        return [
            "title" => "test support category",
            "status" => 5,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'title' => 'updated support category',
        ];
    }
}
