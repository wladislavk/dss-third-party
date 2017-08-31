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

    public function testGetCompanyLogo()
    {
        $this->post(self::ROUTE_PREFIX . '/companies/company-logo');
        $this->assertResponseOk();
        $this->assertNull($this->getResponseData());
    }

    public function testGetHomeSleepTestCompanies()
    {
        $this->post(self::ROUTE_PREFIX . '/companies/home-sleep-test');
        $this->assertResponseOk();
        $this->assertEquals([], $this->getResponseData());
    }

    public function testGetBillingExclusiveCompany()
    {
        $this->post(self::ROUTE_PREFIX . '/companies/billing-exclusive-company');
        $this->assertResponseOk();
        $this->assertNull($this->getResponseData());
    }
}
