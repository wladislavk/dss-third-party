<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalCompany;
use Tests\TestCases\ApiTestCase;

class ExternalCompaniesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return ExternalCompany::class;
    }

    protected function getRoute()
    {
        return '/external-companies';
    }

    protected function getStoreData()
    {
        return [
            'software' => 'test software',
            'name' => 'test name',
            'short_name' => 'test short name',
            'api_key' => 'test api key',
            'valid_from' => 'test valid from',
            'valid_to' => 'test valid to',
            'url' => 'test url',
            'description' => 'test description',
            'status' => 1,
            'created_by' => 0,
            'updated_by' => 2,
            'reason' => 'test reason',
        ];
    }

    protected function getUpdateData()
    {
        return [
            'software' => 'updated software',
            'name' => 'updated name',
        ];
    }
}
