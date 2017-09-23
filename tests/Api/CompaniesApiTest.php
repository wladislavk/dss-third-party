<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Company;
use DentalSleepSolutions\Eloquent\Models\User;
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
        /** @var User $user */
        $user = User::find('u_23');
        $this->be($user);
        $this->post(self::ROUTE_PREFIX . '/companies/company-by-user');
        $this->assertResponseOk();
        $expected = [
            'id' => 1,
            'name' => 'TestCompany',
            'add1' => 'Address1',
            'add2' => 'Address2',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'ZIP',
            'logo' => 'company_logo_1.png',
            'status' => 1,
            'adddate' => '2013-02-25 17:15:07',
            'ip_address' => '128.12.179.156',
            'eligible_api_key' => '33b2e3a5-8642-1285-d573-07a22f8a15b4',
            'stripe_secret_key' => 'sk_test_2Bwg6V5pLmm8Gbidwxc8Iwhk',
            'stripe_publishable_key' => 'pk_test_AwG89We9HPlSSaFDI1TZgnie',
            'monthly_fee' => '325.00',
            'default_new' => 0,
            'free_fax' => 0,
            'sfax_security_context' => 'sFaxTest000037',
            'sfax_app_id' => 'Dental Sleep Solutions',
            'sfax_app_key' => 'y2u2uvegehyjunuzy9e4yhe3arageza8',
            'sfax_init_vector' => 'sf4xt3ts3c%r#fax',
            'fax_fee' => '0.00',
            'company_type' => 1,
            'phone' => null,
            'fax' => null,
            'email' => null,
            'plan_id' => null,
            'sfax_encryption_key' => null,
            'use_support' => 1,
            'exclusive' => 0,
            'vob_require_test' => 1,
        ];
        $this->assertEquals($expected, $this->getResponseData());
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
