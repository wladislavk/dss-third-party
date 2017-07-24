<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Dental\InsuranceDocument;
use Tests\TestCases\ApiTestCase;

class InsuranceDocumentsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return InsuranceDocument::class;
    }

    protected function getRoute()
    {
        return '/insurance-documents';
    }

    protected function getStoreData()
    {
        return [
            'title'       => 'test',
            'description' => 'test description',
            'status'      => 7,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated test description',
        ];
    }
}
