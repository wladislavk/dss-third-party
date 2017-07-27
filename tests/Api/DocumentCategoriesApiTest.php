<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\DocumentCategory;
use Tests\TestCases\ApiTestCase;

class DocumentCategoriesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return DocumentCategory::class;
    }

    protected function getRoute()
    {
        return '/document-categories';
    }

    protected function getStoreData()
    {
        return [
            'name'   => 'John Doe',
            'status' => 5,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'status' => 7,
        ];
    }
}
