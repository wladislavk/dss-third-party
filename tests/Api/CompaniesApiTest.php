<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Company;
use Tests\TestCases\ApiTestCase;

class CompaniesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Company::class;
    }

    protected function getRoute()
    {
        return '/companies';
    }

    protected function getStoreData()
    {
        return [
            'name'   => 'testName',
            'add1'   => 'testAdd1',
            'add2'   => 'testAdd2',
            'city'   => 'testCity',
            'state'  => 'testState',
            'zip'    => '12345',
            'status' => 0,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'name'   => 'testNameUpdated',
            'status' => 2,
        ];
    }
}
