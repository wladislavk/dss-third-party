<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\UserCompany;
use Tests\TestCases\ApiTestCase;

class UserCompaniesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return UserCompany::class;
    }

    protected function getRoute()
    {
        return '/user-companies';
    }

    protected function getStoreData()
    {
        return [
            "userid" => 100,
            "companyid" => 9,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'companyid' => 2,
            'userid'    => 7,
        ];
    }
}
