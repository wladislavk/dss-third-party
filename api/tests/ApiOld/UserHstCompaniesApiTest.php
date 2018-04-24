<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\UserHstCompany;
use Tests\TestCases\ApiTestCase;

class UserHstCompaniesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return UserHstCompany::class;
    }

    protected function getRoute()
    {
        return '/user-hst-companies';
    }

    protected function getStoreData()
    {
        return [
            "userid" => 100,
            "companyid" => 0,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'companyid' => 100,
        ];
    }
}
