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

    protected function getUpdateData()
    {
        return [
            'api_key' => $this->faker->sha1,
        ];
    }
}
