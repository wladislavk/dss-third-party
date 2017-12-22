<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Document;
use Tests\TestCases\ApiTestCase;

class DocumentsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Document::class;
    }

    protected function getRoute()
    {
        return '/documents';
    }

    protected function getStoreData()
    {
        return [
            'categoryid' => 10,
            'name'       => 'test',
            'filename'   => 'test.jpg',
        ];
    }

    protected function getUpdateData()
    {
        return [
            'categoryid' => 15,
        ];
    }
}
